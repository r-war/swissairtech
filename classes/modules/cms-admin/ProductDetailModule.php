<?php
include_once 'AbstractAdminModule.php';

class ProductDetailModule extends AbstractAdminModule
{
	protected $oProductDetail;
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
		$sName = 'Product Detail ';
		if($this->oProduct instanceof Product && !$this->oProduct->isNew() && !$this->oProductDetail->isNew())
			$sName .= ' : '.$this->oProduct->getName();
		return $sName;
	}
	
	public function init()
	{
		$this->oProductDetail = ProductDetailPeer::retrieveByPK(
			$this->oData->get('select',
				$this->oData->get('delete')
			)
		);
            
		if(!$this->oProductDetail instanceof ProductDetail)
		{
			$this->oProductDetail = new ProductDetail();
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

				$this->aContext['oProduct'] = $this->oProduct;
				$this->aContext['oProductDetail'] = $this->oProductDetail;
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
			$bOk = true;
			$aProductDetail = $this->oProduct->getProductDetails();
			if(count($this->oData->get('c')) >= count($aProductDetail))
			{
				$this->error('You must leave minimum 1 detail on this product.');
				$bOk = false;
			}
			
			if(is_array($this->oData->get('c')) && $bOk)
			{
				foreach($this->oData->get('c') as $id)
				{
					$this->oProductDetail = ProductDetailPeer::retrieveByPK($id);
					
					if($this->oProductDetail instanceof ProductDetail)
					{
						$this->doDelete();
					}
				}
				$this->oProductDetail = new ProductDetail();
			}
		}
		$this->preparePage();
	}
	
	private function preparePage()
	{
		$this->regSortable(ProductDetailPeer::getFieldNames(BasePeer::TYPE_COLNAME));
		$this->aContext['oProduct'] = $this->oProduct;
		$this->aContext['aProductDetail'] = ProductDetailPeer::getByProduct(
			$this->oProduct,
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
		if($this->oProductDetail->getSku() == null)
			$this->oProductDetail->setSku(Common::parseSaveURLString($this->oProductDetail->getName()));
		
		if($this->oProductDetail->getPrice() === null) $this->oProductDetail->setPrice(0.00);
		
		$this->doValidate($this->oProductDetail);
		
		if($this->noError())
		{
			$oCon = $this->getCon();
			try
			{
				$oCon->beginTransaction();
				$this->oProductDetail->setProduct($this->oProduct);
				// if($this->oProductDetail->getName2() === null) $this->oProductDetail->setName2('-');
				if($this->oProductDetail->getIndex() === null) $this->oProductDetail->setIndex(0);
				if($this->oProductDetail->getStock() === null) $this->oProductDetail->setStock(0);
				$this->oProductDetail->save();
							
				$oCon->commit();
				
				$this->info('succeed-product_detail-saved',
					array(
						$this->oProductDetail->getName()
					)
				);

				$this->oProductDetail = new ProductDetail();
			}
			catch (Exception $oEx)
			{
				$oCon->rollBack();
				
				$this->error('failed-product_detail-saved',
					array(
						$this->oProductDetail->getName(),
						$oEx->getMessage()
					)
				);
				$this->errorHandler($oEx);
		  	}
		}
	}

	private function doDelete()
	{
		$aProductDetail = $this->oProduct->getProductDetails();
		if(count($aProductDetail) < 2)
		{
			$this->error('You must leave minimum 1 detail on this product. Please update current detail if you want to modify.');
		}

		if($this->noError())
		{
			
			$oCon = $this->getCon();
			try
			{
				$oCon->beginTransaction();
				
				$this->oProductDetail->delete();
				$oCon->commit();
				
				$this->info('succeed-product_detail-deleted',
					array(
						$this->oProductDetail->getName()
					)
				);
			}
			catch (Exception $oEx)
			{
				$oCon->rollBack();
							
				$this->error('failed-product_detail-deleted',
					array(
						$this->oProductDetail->getName(),
						$oEx->getCause()->getMessage()
					)
				);
				$this->errorHandler($oEx);
		  	}
			$this->oProductDetail = new ProductDetail();
		}
	}
}
?>