<?php
include_once 'AbstractAdminModule.php';

class ProductTabModule extends AbstractAdminModule
{
	protected $oProductTab;
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
		$sName = 'Product Tab ';
		if($this->oProduct instanceof Product && !$this->oProduct->isNew())
			$sName .= ' : '.$this->oProduct->getName();
		return $sName;
	}
	
	public function init()
	{
		$this->oProductTab = ProductTabPeer::retrieveByPK(
			$this->oData->get('select',
				$this->oData->get('delete')
			)
		);
            
		if(!$this->oProductTab instanceof ProductTab)
		{
			$this->oProductTab = new ProductTab();
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

				$this->aContext['oProductTab'] = $this->oProductTab;
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
					$this->oProductTab = ProductTabPeer::retrieveByPK($id);
					
					if($this->oProductTab instanceof ProductTab)
					{
						$this->doDelete();
					}
				}
				$this->oProductTab = new ProductTab();
			}
		}
		$this->preparePage();
	}
	
	private function preparePage()
	{
		$this->regSortable(ProductTabPeer::getFieldNames(BasePeer::TYPE_COLNAME));
		$this->aContext['oProduct'] = $this->oProduct;
		$this->aContext['aProductTab'] = ProductTabPeer::getByProduct(
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
		$this->oProductTab->setDescription($this->oData->get('description'));
		$this->doValidate($this->oProductTab);
		
		if($this->noError())
		{
			$oCon = $this->getCon();
			try
			{
				$oCon->beginTransaction();
				$this->oProductTab->setProduct($this->oProduct);
				if($this->oProductTab->getIndex() === null) $this->oProductTab->setIndex(0);
				$this->oProductTab->save();
							
				$oCon->commit();
				
				$this->info('succeed-product_tab-saved',
					array(
						$this->oProductTab->getName()
					)
				);
				
				$this->oProductTab = new ProductTab();
			}
			catch (Exception $oEx)
			{
				$oCon->rollBack();
				
				$this->error('failed-product_tab-saved',
					array(
						$this->oProductTab->getName(),
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
			
			$this->oProductTab->delete();
			$oCon->commit();
			
			$this->info('succeed-product_tab-deleted',
				array(
					$this->oProductTab->getName()
				)
			);
		}
		catch (Exception $oEx)
		{
			$oCon->rollBack();
						
			$this->error('failed-product_tab-deleted',
				array(
					$this->oProductTab->getName(),
					$oEx->getCause()->getMessage()
				)
			);
			$this->errorHandler($oEx);
	  	}
		$this->oProductTab = new ProductTab();
	}
}
?>