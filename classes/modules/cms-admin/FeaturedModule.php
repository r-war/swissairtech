<?php
include_once 'AbstractAdminModule.php';

class FeaturedModule extends AbstractAdminModule
{
	protected $oProductFeatured;
	protected $sType;
	
	public function getName()
	{
		$sName = 'Featured';
		
		if($this->sGroup == 'featured')
			$sName = 'Featured Products';
		elseif($this->sGroup == 'hot')
			$sName = 'Hot Products';
		
		return $sName;
	}
	
	public function init()
	{
		$this->oProductFeatured = ProductFeaturedPeer::retrieveByPK(
			$this->oData->get('select',
				$this->oData->get('delete')
			)
		);
            
		if(!$this->oProductFeatured instanceof ProductFeatured)
		{
			$this->oProductFeatured = new ProductFeatured();
		}
		
		$this->sType = $this->oData->get('mode');
		$this->addLink('mode='.$this->oData->get('mode'));
		if(eregi('product_', $this->sType))
		{
			$this->aContext['oProduct'] = ProductPeer::retrieveByPK(str_replace('product_', '', $this->sType));
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
				
			case 'form':
				if($this->oData->isExists('keywords')) $this->addLink('keywords='.urlencode($this->oData->get('keywords')));
				if($this->oData->isExists('save'))
					$this->doSave();
				
				$this->aContext['oProductFeatured'] = $this->oProductFeatured;
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
					$this->oProductFeatured = ProductFeaturedPeer::retrieveByPK($id);
					
					if($this->oProductFeatured instanceof ProductFeatured)
					{
						$this->doDelete();
					}
				}
				$this->oProductFeatured = new ProductFeatured();
			}
		}
		$this->preparePage();
	}
	
	private function preparePage()
	{
		$this->regSortable(ProductFeaturedPeer::getFieldNames(BasePeer::TYPE_COLNAME));
		$this->aContext['aProductFeatured'] = ProductFeaturedPeer::getByType(
			$this->sType,
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
		$oProduct = ProductPeer::retrieveByPK($this->oData->get('productid'));
		if(!$oProduct instanceof Product)
			$this->error('required-product');
		else
		{
			$oProductFeatured = ProductFeaturedPeer::getNotSelfByTypeAndProduct($this->oProductFeatured, $this->sType, $oProduct);
			if($oProductFeatured instanceof ProductFeatured)
				$this->error('existed-product');
			$this->oProductFeatured->setProduct($oProduct);
		}
		$this->doValidate($this->oProductFeatured);
		
		if($this->noError())
		{
			$oCon = $this->getCon();
			try
			{
				$oCon->beginTransaction();
				$this->oProductFeatured->setType($this->sType);
				if($this->oProductFeatured->getIndex() === null) $this->oProductFeatured->setIndex(0);
				$this->oProductFeatured->save();
				$oCon->commit();

				$this->info('succeed-featured-saved',
					array(
						$this->oProductFeatured->getName()
					)
				);
				
				$this->oProductFeatured = new ProductFeatured();
			}
			catch (Exception $oEx)
			{
				$oCon->rollBack();
				$this->error('failed-featured-saved',
					array(
						$this->oProductFeatured->getName(),
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
			
			$this->oProductFeatured->delete();
			
			$oCon->commit();
			
			$this->info('succeed-featured-deleted',
				array(
					$this->oProductFeatured->getName()
				)
			);
		}
		catch (Exception $oEx)
		{
			$oCon->rollBack();
						
			$this->error('failed-featured-deleted',
				array(
					$this->oProductFeatured->getName(),
					$oEx->getCause()->getMessage()
				)
			);
			$this->errorHandler($oEx);
	  	}
		$this->oProductFeatured = new ProductFeatured();
	}
}
?>