<?php
include_once 'AbstractAdminModule.php';

class ProductPopupModule extends AbstractAdminModule
{
	protected $oProductPopup;
	protected $oProduct;
	protected $oProductDetail;
	
	public function isRedirect()
	{
		if(parent::isRedirect()) return true;
		
		$this->oProduct = ProductPeer::retrieveByPK($this->oData->get('sub'));
		if($this->oProduct instanceof Product)
			return false;
	}

	public function getRedirectModule()
	{
		return array('','Product');
	}
	
	public function isAuthorized()
	{
		if($this->isAdminLogin() && !$this->isRedirect())
			return in_array('Product', $this->oLoginAdmin->getPrivilegesArray());
		else
			return parent::isAuthorized();
	}
	
	public function getName()
	{
		$sName = 'Product Popup ';
		if($this->oProduct instanceof Product && !$this->oProduct->isNew() && !$this->oProductPopup->isNew())
			$sName .= ' : '.$this->oProduct->getName();
		return $sName;
	}
	
	public function init()
	{
		$this->oProductDetail = ProductDetailPeer::retrieveByPK($this->oData->get('sub2'));
		
		$this->oProductPopup = ProductPopupPeer::retrieveByPK(
			$this->oData->get('select',
				$this->oData->get('delete')
			)
		);
            
		if(!$this->oProductPopup instanceof ProductPopup)
		{
			$this->oProductPopup = new ProductPopup();
		}

		$this->addLink('sub='. $this->oProduct->getPrimaryKey());
		$this->addLink('sub2='. $this->oData->get('sub2'));
	}

	public function ajaxHandler($sAjax)
	{
		switch($sAjax)
		{
			case 'form':
				if($this->oData->isExists('keywords')) $this->addLink('keywords='.urlencode($this->oData->get('keywords')));
				if($this->oData->isExists('save'))
					$this->doSave();

				$this->aContext['oProductPopup'] = $this->oProductPopup;
				break;
		}
	}
	
	
	public function doBuildTemplate()
	{
		if($this->oData->isExists('delete'))
		{
			$this->doDelete();
		}
		else if($this->oData->isExists('deleteChecked'))
		{
			if(is_array($this->oData->get('c')))
			{
				foreach($this->oData->get('c') as $id)
				{
					$this->oProductPopup = ProductPopupPeer::retrieveByPK($id);
					
					if($this->oProductPopup instanceof ProductPopup)
					{
						$this->doDelete();
					}
				}
				$this->oProductPopup = new ProductPopup();
			}
		}
		$this->preparePage();
	}
	
	private function preparePage()
	{
		$this->regSortable(ProductPopupPeer::getFieldNames(BasePeer::TYPE_COLNAME));
		$this->aContext['oProduct'] = $this->oProduct;
		$this->aContext['oProductDetail'] = $this->oProductDetail;
		$this->aContext['aProductPopup'] = ProductPopupPeer::getByProductOrProductDetail(
			$this->oProduct,
			$this->oProductDetail,
			$this->doHandleParameter(),
			$this->getSortable(),
			$this->getPageList(),
			$oPager
		);

		$this->regPageList(
			$oPager
		);
	}
	
	private function doSave()
	{
		if($_FILES['picture']['name'])
		{
			$sFilename = $this->processUpload(
					'picture',
					'contents/'.$this->oApp->sDomain.'/images/',
					explode(',',BannerPeer::FILE_TYPE_IMAGE),
					null,
					false,
					true
			);
			
			if($sFilename)
			{
				$sFile = 'contents/'.$this->oApp->sDomain.'/images/'.$sFilename;
				if($this->oProductPopup->getPicture() != '')
				{
					$sOldFile = 'contents/'.$this->oApp->sDomain.'/images/'.$this->oProductPopup->getPicture();
				}
				$this->oProductPopup->setPicture($sFilename);
			}
		}
		if($this->oProductPopup->getPicture() == '')
			$this->errorInline('picture', 'required-picture');
		
		$this->doValidate($this->oProductPopup);
		if($this->noError())
		{
			$oCon = $this->getCon();
			try
			{
				$oCon->beginTransaction();
				$this->oProductPopup->setProduct($this->oProduct);
				if($this->oProductPopup->getIndex() === null) $this->oProductPopup->setIndex(0);
				
				if($this->oProductDetail instanceof ProductDetail)
					$this->oProductPopup->setProductDetail($this->oProductDetail);
				
				$this->oProductPopup->save();
							
				$oCon->commit();
				if($sOldFile && is_file($sOldFile))	unlink($sOldFile);
				$this->info('succeed-product_popup-saved',
					array(
						$this->oProductPopup->getPicture()
					)
				);

				$this->oProductPopup = new ProductPopup();

			}
			catch (Exception $oEx)
			{
				$oCon->rollBack();
				if($sFile && is_file($sFile))	unlink($sFile);
				$this->error('failed-product_popup-saved',
					array(
						$this->oProductPopup->getPicture(),
						$oEx->getMessage()
					)
				);
				$this->errorHandler($oEx);
		  	}
		}
		else {
			if($sFile && is_file($sFile))	unlink($sFile);
		}
	}

	private function doDelete()
	{
		$oCon = $this->getCon();
		try
		{
			$oCon->beginTransaction();
			
			$this->oProductPopup->delete();
			$oCon->commit();
			
			$this->info('succeed-product_popup-deleted',
				array(
					$this->oProductPopup->getPicture()
				)
			);
		}
		catch (Exception $oEx)
		{
			$oCon->rollBack();
						
			$this->error('failed-product_popup-deleted',
				array(
					$this->oProductPopup->getPicture(),
					$oEx->getCause()->getMessage()
				)
			);
			$this->errorHandler($oEx);
	  	}
		$this->oProductPopup = new ProductPopup();
	}
}
?>