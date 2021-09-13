<?php
include_once 'AbstractAdminModule.php';

class ProductUserModule extends AbstractAdminModule
{
	protected $oProductUser;
	
	public function getName()
	{
		$sName = 'Assign Property';
		
		return $sName;
	}
	
	public function init()
	{
		$this->oProductUser = ProductUserPeer::retrieveByPK(
			$this->oData->get('select',
				$this->oData->get('delete')
			)
		);
            
		$this->addLink('userid='.$this->oData->get('userid'));
		$this->addLink('productid='.$this->oData->get('productid'));
		if(!$this->oProductUser instanceof ProductUser)
		{
			$this->oProductUser = new ProductUser();
			$this->oProductUser->setProductId($this->oData->get('productid'));
			$this->oProductUser->setUserId($this->oData->get('userid'));
		}
	}
	
	public function ajaxHandler($sAjax)
	{
		switch($sAjax)
		{
			case 'product':
				$aBook = array();
				$oParam = new Parameter();
				$oParam->set('keywords',$this->oData->get('q'));
				$aProduct = ProductPeer::getAll(
					$oParam,null,1,$null,$this->oData->get('limit')
				);
				foreach ($aProduct as $oProduct)
				{
					$aBook[] = array( 
						'id' => $oProduct->getId(),
						'name' => $oProduct->getName()
					);
				}
				$this->aContext['aData'] = $aBook;
				break;
				
			case 'user':
				$aBook = array();
				$oParam = new Parameter();
				$oParam->set('keywords',$this->oData->get('q'));
				$aProduct = UserPeer::getAll(
					$oParam,null,1,$null,$this->oData->get('limit')
				);
				foreach ($aProduct as $oProduct)
				{
					$aBook[] = array( 
						'id' => $oProduct->getId(),
						'name' => $oProduct->getName()
					);
				}
				$this->aContext['aData'] = $aBook;
				break;	
				
			case 'form':
				if($this->oData->isExists('keywords')) $this->addLink('keywords='.urlencode($this->oData->get('keywords')));
				if($this->oData->isExists('save'))
					$this->doSave();
				
				$this->aContext['oProductUser'] = $this->oProductUser;
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
					$this->oProductUser = ProductUserPeer::retrieveByPK($id);
					
					if($this->oProductUser instanceof ProductUser)
					{
						$this->doDelete();
					}
				}
				$this->oProductUser = new ProductUser();
			}
		}
		$this->preparePage();
	}
	
	private function preparePage()
	{
		$this->regSortable(ProductUserPeer::getFieldNames(BasePeer::TYPE_COLNAME));
		
		$oParam = $this->doHandleParameter();
		if($this->oData->isExists('productid'))
			$oParam->set('productid', $this->oData->get('productid'));
		if($this->oData->isExists('userid'))
			$oParam->set('userid', $this->oData->get('userid'));
		
		$this->aContext['aProductUser'] = ProductUserPeer::getAll(
			$oParam,
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
		$oProduct = ProductPeer::retrieveByPK($this->oData->get('productid'));
		if(!$oProduct instanceof Product)
			$this->error('required-product');
		
		$oUser = UserPeer::retrieveByPK($this->oData->get('userid'));
		if(!$oUser instanceof $oUser)
			$this->error('required-user');
		
		if($oProduct instanceof Product && $oUser instanceof User)
		{
			$oProductUser = ProductUserPeer::getNotSelfByUserProduct($this->oProductUser, $oUser, $oProduct);
			if($oProductUser instanceof ProductUser)
				$this->error('existed-product');
		}

		$this->oProductUser->setUser($oUser);
		$this->oProductUser->setProduct($oProduct);

		$this->doValidate($this->oProductUser);
		
		if($this->noError())
		{
			$oCon = $this->getCon();
			try
			{
				$oCon->beginTransaction();
				$this->oProductUser->save();
				$oCon->commit();

				$this->info('succeed-product-saved',
					array(
						$this->oProductUser->getName()
					)
				);
				
				$this->oProductUser = new ProductUser();
			}
			catch (Exception $oEx)
			{
				$oCon->rollBack();
				$this->error('failed-product-saved',
					array(
						$this->oProductUser->getName(),
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
			
			$this->oProductUser->delete();
			
			$oCon->commit();
			
			$this->info('succeed-product-deleted',
				array(
					$this->oProductUser->getName()
				)
			);
		}
		catch (Exception $oEx)
		{
			$oCon->rollBack();
						
			$this->error('failed-product-deleted',
				array(
					$this->oProductUser->getName(),
					$oEx->getCause()->getMessage()
				)
			);
			$this->errorHandler($oEx);
	  	}
		$this->oProductUser = new ProductUser();
	}
}
?>