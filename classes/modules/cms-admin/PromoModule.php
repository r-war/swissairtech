<?php
include_once 'AbstractAdminModule.php';

class PromoModule extends AbstractAdminModule
{
	protected $oPromo;
	protected $oPromoAttribute;
	
	public function getName()
	{
		$sName = 'Promo';
		// if($this->oPromo instanceof Promo && !$this->oPromo->isNew())
			// $sName .= ' : '.$this->oPromo->getName();
		return $sName;
	}
	
	public function init()
	{
		$this->oPromo = PromoPeer::retrieveByPK(
			$this->oData->get('select',
				$this->oData->get('delete')
			)
		);
            
		if(!$this->oPromo instanceof Promo)
		{
			$this->oPromo = new Promo();
		}
		
		if($this->oData->isExists('attr') && !$this->oPromo->isNew())
		{
			if($this->oPromo->getDiscType() == 1)
			{
				$this->oPromoAttribute = PromoProductPeer::retrieveByPK(
					$this->oData->get('selectattr',
						$this->oData->get('deleteattr')
					)
				);
				
				if(!$this->oPromoAttribute instanceof PromoProduct)
				{
					$this->oPromoAttribute = new PromoProduct();
				}
			}
			elseif($this->oPromo->getDiscType() == 2)
			{
				$this->oPromoAttribute = PromoCouponPeer::retrieveByPK(
					$this->oData->get('selectattr',
						$this->oData->get('deleteattr')
					)
				);
				
				if(!$this->oPromoAttribute instanceof PromoCoupon)
				{
					$this->oPromoAttribute = new PromoCoupon();
				}
			}
		}
	}
	
	public function ajaxHandler($sAjax)
	{
		switch($sAjax)
		{
			case 'product':
				$aData = array();
				$oParam = new Parameter();
				$oParam->set('keywords',$this->oData->get('q'));
				$aPage = ProductPeer::getAll(
					$oParam,null,1,$null,$this->oData->get('limit')
				);
				foreach ($aPage as $oPage)
				{
					$aData[] = array( 
						'id' => $oPage->getId(),
						'name' => $oPage->getName()
					);
				}
				$this->aContext['aData'] = $aData;
				break;
				
			case 'form':
				if($this->oData->isExists('keywords')) $this->addLink('keywords='.urlencode($this->oData->get('keywords')));
				if($this->oData->isExists('save') && $this->oData->isExists('attr'))
				{
					$this->doSaveAttribute();
				}
				elseif($this->oData->isExists('save'))
				{
					$this->doSave();
				}
				
				$this->aContext['oPromo'] = $this->oPromo;
				if($this->oData->isExists('attr') && !$this->oPromo->isNew())
				{
					$this->addLink('attr=1');
					$this->addLink('select='.$this->oPromo->getPrimaryKey());
					$this->aContext['bAttr'] = true;
					$this->aContext['oPromoAttribute'] = $this->oPromoAttribute;
				}
			break;

		}
	}
	
	public function doBuildTemplate()
	{
		if($this->oData->isExists('saveall') && $this->oData->isExists('attr'))
		{
			$this->doSaveAttributeAll();
		}
		else if($this->oData->isExists('delete'))
		{
			$this->doDelete();
		}
		else if($this->oData->isExists('deleteattr'))
		{
			$this->doDeleteAttribute();
		}
		else if($this->oData->isExists('deleteChecked'))
		{
			if(is_array($this->oData->get('c')))
			{
				foreach($this->oData->get('c') as $id)
				{
					$this->oPromo = PromoPeer::retrieveByPK($id);
					
					if($this->oPromo instanceof Promo)
					{
						$this->doDelete();
					}
				}
				$this->oPromo = new Promo();
			}
		}
		else if($this->oData->isExists('deleteCheckedAttr'))
		{
			if(is_array($this->oData->get('c')))
			{
				foreach($this->oData->get('c') as $id)
				{
					if($this->oPromo->getDiscType() == 1)
					{
						$this->oPromoAttribute = PromoProductPeer::retrieveByPK($id);
						
						if($this->oPromoAttribute instanceof PromoProduct)
						{
							$this->doDeleteAttribute();
						}
					}
					elseif($this->oPromo->getDiscType() == 2)
					{
						$this->oPromoAttribute = PromoCouponPeer::retrieveByPK($id);
						
						if($this->oPromoAttribute instanceof PromoCoupon)
						{
							$this->doDeleteAttribute();
						}
					}
				}
				if($this->oPromo->getDiscType() == 1)
					$this->oPromoAttribute = new PromoProduct();
				elseif($this->oPromo->getDiscType() == 2)
					$this->oPromoAttribute = new PromoCoupon();				
				}
		}
		$this->preparePage();
	}
	
	private function preparePage()
	{
		$this->aContext['oPromo'] = $this->oPromo;
		if($this->oData->isExists('attr') && !$this->oPromo->isNew())
		{
			$this->addLink('attr=1');
			$this->addLink('select='.$this->oPromo->getPrimaryKey());
			$this->aContext['bAttr'] = true;
			$this->aContext['oPromoAttribute'] = $this->oPromoAttribute;

			if($this->oPromo->getDiscType() == 1)
			{
				$this->regSortable(ProductPeer::getFieldNames(BasePeer::TYPE_COLNAME));
				$this->aContext['aPromoAttribute'] = PromoProductPeer::getByPromo(
					$this->oPromo,
					$this->doHandleParameter(),
					$this->getSortable(),
					$this->getPageList(),
					$oPager
				);
			}
			elseif($this->oPromo->getDiscType() == 2)
			{
				$this->regSortable(PromoCouponPeer::getFieldNames(BasePeer::TYPE_COLNAME));
				
				$this->aContext['aPromoAttribute'] = PromoCouponPeer::getByPromo(
					$this->oPromo,
					$this->doHandleParameter(),
					$this->getSortable(),
					$this->getPageList(),
					$oPager
				);
			}
			
			$this->regPageList(
				$oPager
			);
		}
		else
		{
			$this->regSortable(PromoPeer::getFieldNames(BasePeer::TYPE_COLNAME));
			
			$this->aContext['aPromo'] = PromoPeer::getAll(
				$this->doHandleParameter(),
				$this->getSortable(),
				$this->getPageList(),
				$oPager
			);
	
			$this->regPageList(
				$oPager
			);
		}
	}
	
	private function doSave()
	{
		$this->oPromo->setDescription($this->oData->get('description'));
		$this->doValidate($this->oPromo);
		if($this->noError())
		{
			$oCon = $this->getCon();
			try
			{
				$oCon->beginTransaction();
				$this->oPromo->save();

				$oCon->commit();
				
				$this->info('succeed-promo-saved',
					array(
						$this->oPromo->getName()
					)
				);
				
				$this->oPromo = new Promo();
			}
			catch (Exception $oEx)
			{
				$oCon->rollBack();

				$this->error('failed-promo-saved',
					array(
						$this->oPromo->getName(),
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
			$this->oPromo->delete();
			$oCon->commit();
			
			$this->info('succeed-promo-deleted',
				array(
					$this->oPromo->getName()
				)
			);
		}
		catch (Exception $oEx)
		{
			$oCon->rollBack();
						
			$this->error('failed-promo-deleted',
				array(
					$this->oPromo->getName(),
					$oEx->getCause()->getMessage()
				)
			);
			$this->errorHandler($oEx);
	  	}
		$this->oPromo = new Promo();
	}

	private function doSaveAttribute()
	{
		if($this->oPromo->getDiscType() == 1)
		{
			$oProduct = ProductPeer::retrieveByPK($this->oData->get('productid'));
			if(!$oProduct instanceof Product)
				$this->error('required-product');
			else
			{
				$oPromoProduct = PromoProductPeer::getNotSelfByPromoAndProduct($this->oPromoAttribute, $this->oPromo, $oProduct);
				if($oPromoProduct instanceof PromoProduct)
					$this->error('existed-product');
			
				$this->oPromoAttribute->setProduct($oProduct);
			}
		}
		elseif($this->oPromo->getDiscType() == 2)
		{
			$oPromoCoupon = PromoCouponPeer::getNotSelf($this->oPromoAttribute);
			if($oPromoCoupon instanceof PromoCoupon)
				$this->error('existed-coupon');
			
			if($this->oPromoAttribute->getUnlimited() == null)
				$this->oPromoAttribute->setUnlimited(false);
		}
		
		if($this->oPromoAttribute->getPromoId() == null)
			$this->oPromoAttribute->setPromo($this->oPromo);
		$this->doValidate($this->oPromoAttribute);
		if($this->noError())
		{
			$oCon = $this->getCon();
			try
			{
				$oCon->beginTransaction();
				$this->oPromoAttribute->save();
				$oCon->commit();
				
				$this->info('succeed-promo-saved',
					array(
						$this->oPromoAttribute->getName()
					)
				);

				if($this->oPromo->getDiscType() == 1)
					$this->oPromoAttribute = new PromoProduct();
				elseif($this->oPromo->getDiscType() == 2)
					$this->oPromoAttribute = new PromoCoupon();
			}
			catch (Exception $oEx)
			{
				$oCon->rollBack();
				$this->error('failed-promo-saved',
					array(
						$this->oPromoAttribute->getName(),
						$oEx->getMessage()
					)
				);
				$this->errorHandler($oEx);
		  	}
		}
	}
	
	private function doDeleteAttribute()
	{
		$oCon = $this->getCon();
		try
		{
			$oCon->beginTransaction();
				
			$this->oPromoAttribute->delete();
			$oCon->commit();
			
			$this->info('succeed-promo-deleted',
				array(
					$this->oPromoAttribute->getName()
				)
			);
		}
		catch (Exception $oEx)
		{
			$oCon->rollBack();
						
			$this->error('failed-promo-deleted',
				array(
					$this->oPromoAttribute->getName(),
					$oEx->getCause()->getMessage()
				)
			);
			$this->errorHandler($oEx);
	  	}
		if($this->oPromo->getDiscType() == 1)
			$this->oPromoAttribute = new PromoProduct();
		elseif($this->oPromo->getDiscType() == 2)
			$this->oPromoAttribute = new PromoCoupon();		

  	}
  	
	private function doSaveAttributeAll()
	{
		if($this->oPromo->getDiscType() == 1)
		{
			$oCon = $this->getCon();
			try
			{
				$oCon->beginTransaction();
				$aProduct = ProductPeer::getAll();
				foreach($aProduct as $oProduct)
				{
					$oPromoProduct = PromoProductPeer::getByPromoAndProduct($this->oPromo, $oProduct);
					if(!$oPromoProduct instanceof PromoProduct)
					{	
						$oPromoProduct = new PromoProduct();
						$oPromoProduct->setPromo($this->oPromo);
						$oPromoProduct->setProduct($oProduct);
						$oPromoProduct->save();
					}
				}
				$oCon->commit();
				
				$this->info('succeed-promo-saved',
					array(
						$this->oPromo->getName()
					)
				);
			}
			catch (Exception $oEx)
			{
				$oCon->rollBack();
				$this->error('failed-promo-saved',
					array(
						$this->oPromo->getName(),
						$oEx->getMessage()
					)
				);
				$this->errorHandler($oEx);
		  	}

			if($this->oPromo->getDiscType() == 1)
				$this->oPromoAttribute = new PromoProduct();
			elseif($this->oPromo->getDiscType() == 2)
				$this->oPromoAttribute = new PromoCoupon();				
									
		}
	}
  	
}
?>