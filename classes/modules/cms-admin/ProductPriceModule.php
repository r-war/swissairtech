<?php
include_once 'AbstractAdminModule.php';

class ProductPriceModule extends AbstractAdminModule
{
	protected $oProductPrice;
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
		$sName = 'Product Price';
		if($this->oProduct instanceof Product && !$this->oProduct->isNew())
			$sName .= ' : '.$this->oProduct->getName();
		return $sName;
	}
	
	public function init()
	{
		$this->oProductPrice = ProductPricePeer::retrieveByPK(
			$this->oData->get('select',
				$this->oData->get('delete')
			)
		);
            
		if(!$this->oProductPrice instanceof ProductPrice)
		{
			$this->oProductPrice = new ProductPrice();
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
				$this->aContext['oProductPrice'] = $this->oProductPrice;
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
					$this->oProductPrice = ProductPricePeer::retrieveByPK($id);
					
					if($this->oProductPrice instanceof ProductPrice)
					{
						$this->doDelete();
					}
				}
				$this->oProductPrice = new ProductPrice();
			}
		}
		$this->preparePage();
	}
	
	private function preparePage()
	{
		$this->regSortable(ProductPricePeer::getFieldNames(BasePeer::TYPE_COLNAME));
		$this->aContext['oProduct'] = $this->oProduct;
		$this->aContext['aProductPrice'] = ProductPricePeer::getByProduct(
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
		$this->doValidate($this->oProductPrice);
		
		if($this->noError())
		{
			$oCon = $this->getCon();
			try
			{
				$oCon->beginTransaction();
				$this->oProductPrice->setProduct($this->oProduct);
				$this->oProductPrice->save();
							
				$oCon->commit();
				
				$this->info('succeed-product_price-saved',
					array(
						$this->oProduct->getName()
					)
				);
		
				$this->oProductPrice = new ProductPrice();
			}
			catch (Exception $oEx)
			{
				$oCon->rollBack();
				
				$this->error('failed-product_price-saved',
					array(
						$this->oProduct->getName(),
						$oEx->getMessage()
					)
				);
				$this->errorHandler($oEx);
		  	}
		}
	}

	private function doDelete()
	{
		$oCon = $this->getCon();
		try
		{
			$oCon->beginTransaction();
			
			$this->oProductPrice->delete();
			$oCon->commit();
			
			$this->info('succeed-product_price-deleted',
				array(
					$this->oProduct->getName()
				)
			);
		}
		catch (Exception $oEx)
		{
			$oCon->rollBack();
						
			$this->error('failed-product_price-deleted',
				array(
					$this->oProduct->getName(),
					$oEx->getCause()->getMessage()
				)
			);
			$this->errorHandler($oEx);
	  	}
		$this->oProductPrice = new ProductPrice();
	}
}
?>