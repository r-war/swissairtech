<?php
include_once 'AbstractAdminModule.php';

class ProductPictureModule extends AbstractAdminModule
{
	protected $oProductPicture;
	protected $oProduct;
	
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
		$sName = 'Product Picture ';
		if($this->oProduct instanceof Product && !$this->oProduct->isNew() && !$this->oProductPicture->isNew())
			$sName .= ' : '.$this->oProduct->getName();
		return $sName;
	}
	
	public function init()
	{
		$this->oProductPicture = ProductPicturePeer::retrieveByPK(
			$this->oData->get('select',
				$this->oData->get('delete')
			)
		);
            
		if(!$this->oProductPicture instanceof ProductPicture)
		{
			$this->oProductPicture = new ProductPicture();
		}

		$this->addLink('sub='. $this->oProduct->getPrimaryKey());
	}

	public function ajaxHandler($sAjax)
	{
		switch($sAjax)
		{
			case 'form':
				if($this->oData->isExists('keywords')) $this->addLink('keywords='.urlencode($this->oData->get('keywords')));
				if($this->oData->isExists('save'))
					$this->doSave();

				$this->aContext['oProductPicture'] = $this->oProductPicture;
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
					$this->oProductPicture = ProductPicturePeer::retrieveByPK($id);
					
					if($this->oProductPicture instanceof ProductPicture)
					{
						$this->doDelete();
					}
				}
				$this->oProductPicture = new ProductPicture();
			}
		}
		$this->preparePage();
	}
	
	private function preparePage()
	{
		$this->regSortable(ProductPicturePeer::getFieldNames(BasePeer::TYPE_COLNAME));
		$this->aContext['oProduct'] = $this->oProduct;
		$this->aContext['aProductPicture'] = ProductPicturePeer::getByProductOrProductDetail(
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
				if($this->oProductPicture->getPicture() != '')
				{
					$sOldFile = 'contents/'.$this->oApp->sDomain.'/images/'.$this->oProductPicture->getPicture();
				}
				$this->oProductPicture->setPicture($sFilename);
			}
		}
		if($this->oProductPicture->getPicture() == '')
			$this->errorInline('picture', 'required-picture');
		
		$this->doValidate($this->oProductPicture);
		if($this->noError())
		{
			$oCon = $this->getCon();
			try
			{
				$oCon->beginTransaction();
				$this->oProductPicture->setProduct($this->oProduct);
				if($this->oProductPicture->getIndex() === null) $this->oProductPicture->setIndex(0);
				
				$this->oProductPicture->save();
							
				$oCon->commit();
				if($sOldFile && is_file($sOldFile))	unlink($sOldFile);
				$this->info('succeed-product_picture-saved',
					array(
						$this->oProductPicture->getPicture()
					)
				);
				$this->oProductPicture = new ProductPicture();
			}
			catch (Exception $oEx)
			{
				$oCon->rollBack();
				if($sFile && is_file($sFile))	unlink($sFile);
				$this->error('failed-product_picture-saved',
					array(
						$this->oProductPicture->getPicture(),
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
			
			$this->oProductPicture->delete();
			$oCon->commit();
			
			$this->info('succeed-product_picture-deleted',
				array(
					$this->oProductPicture->getPicture()
				)
			);
		}
		catch (Exception $oEx)
		{
			$oCon->rollBack();
						
			$this->error('failed-product_picture-deleted',
				array(
					$this->oProductPicture->getPicture(),
					$oEx->getCause()->getMessage()
				)
			);
			$this->errorHandler($oEx);
	  	}
		$this->oProductPicture = new ProductPicture();
	}
}
?>