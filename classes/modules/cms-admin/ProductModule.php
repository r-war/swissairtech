<?php
include_once 'AbstractAdminModule.php';

class ProductModule extends AbstractAdminModule
{
	protected $oProduct;
	protected $oCategory;
	
	public function getName()
	{
		$sCode = $this->oLoc->get('product');
		if($this->oProduct instanceof Product && !$this->oProduct->isNew())
			$sCode .= ' : '.$this->oProduct->getCode();
		return $sCode;
	}
	
	public function init()
	{
		$this->oProduct = ProductPeer::retrieveByPK($this->oData->get('select',$this->oData->get('delete')));
		if(!$this->oProduct instanceof Product)
		{
			$this->oProduct = new Product();
		}
		elseif($this->oProduct instanceof Product) 
		{
			$this->oCategory = $this->oProduct->getCategory();
		}
		
		if(!is_null($this->oData->get('sub')))
		{
			$this->oCategory = CategoryPeer::retrieveByPK($this->oData->get('sub'));
			if($this->oCategory instanceof Category)
			{
				$this->addLink('sub='. $this->oCategory->getPrimaryKey());
				$this->oProductCategory = CategoryPeer::retrieveByPK($this->oData->get('sub'));
			}
		}
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
				$this->aContext['aCategoryArray'] = $this->oProduct->getCategoryArray();
				$this->aContext['oCategory'] = $this->oCategory;
				$this->aContext['aCategory'] = CategoryPeer::getByParent();
				
				break;
		}
	}
	
	public function doBuildTemplate()
	{
		if($this->oData->isExists('delete'))
		{
			$this->doDelete();
		}
		elseif($_FILES['uploadfile']['name'])
		{
			$this->doImport();
		}
		else if($this->oData->isExists('deleteChecked'))
		{
			if(is_array($this->oData->get('c')))
			{
				foreach($this->oData->get('c') as $id)
				{
					$this->oProduct = ProductPeer::retrieveByPK($id);
					
					if($this->oProduct instanceof Product)
					{
						$this->doDelete();
					}
				}
				$this->oProduct = new Product();
			}
		}
		$this->preparePage();
	}
	
	private function preparePage()
	{
		$this->regSortable(
			array_merge(
				ProductPeer::getFieldNames(BasePeer::TYPE_COLNAME)
			)
		);
		
		$this->aContext['oCategory'] = $this->oCategory;
		$this->aContext['aProduct'] = ProductPeer::getByCategory(
			$this->oCategory,
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
		if($this->oProduct->isNew()) $bRedirect = true;
		
		$this->oProduct->setCode(Common::parseSaveURLString($this->oProduct->getName()));

		$this->oProduct->setName($this->oData->get('name'),'en');
		$this->oProduct->setDescription($this->oData->get('description'),'en');
		$this->oProduct->setName($this->oData->get('namecn'),'cn');
		$this->oProduct->setDescription($this->oData->get('descriptioncn'),'cn');
		
		// $this->oProduct->setShortDescription($this->oData->get('shortDescription'));
		$aCat = $this->oData->get('category');
		if(!is_array($aCat) || count($aCat) == 0)
			$this->errorInline('category','required-category');
		$this->doValidate($this->oProduct);
		// $this->doValidate($this->oProductDetail);
		
		if($this->noError())
		{
			$oCon = $this->getCon();
			try
			{
				$oCon->beginTransaction();
				$this->oProduct->setDate(Application::getFormalDateTime());
				if($this->oProduct->getIndex() === null) $this->oProduct->setIndex(0);
				// $aExtra = $this->oData->get('extra');
				$this->oProduct->save();
		
				// if($this->oProductDetail->getName2() === null) $this->oProductDetail->setName2('-');
				// if($this->oProductDetail->getIndex() === null) $this->oProductDetail->setIndex(0);
				// if($this->oProductDetail->getStock() === null) $this->oProductDetail->setStock(0);
				// $this->oProductDetail->setProduct($this->oProduct);
				// $this->oProductDetail->save();
		
				$this->oProduct->setCategory($aCat);
				
				// $iPromoId = $this->oData->get('promoid');
				// $oCurrentPromo = PromoPeer::getAnyForProduct($this->oProduct);
				// if($oCurrentPromo instanceof Promo)
				// {
					// if($oCurrentPromo->getId() != $iPromoId)
					// {
						// $oCrit = new Criteria();
						// $oCrit->add(PromoProductPeer::PRODUCT_ID, $this->oProduct->getId());
						// PromoProductPeer::doDelete($oCrit);
					// }
					// else
						// $iPromoId = null;
				// }
// 				
				// if($iPromoId)
				// {
					// $oPromo = PromoPeer::retrieveByPK($iPromoId);
					// $oPromoProduct = new PromoProduct();
					// $oPromoProduct->setPromo($oPromo);
					// $oPromoProduct->setProduct($this->oProduct);
					// $oPromoProduct->save();
				// }
					
				$oCon->commit();
				
				$this->info('succeed-product-saved',
					array(
						$this->oProduct->getCode()
					)
				);
				$this->oProduct = new Product();
				// $this->oProductDetail = new ProductDetail();
			}
			catch (Exception $oEx)
			{
				$oCon->rollBack();
				
				$this->error('failed-product-saved',
					array(
						$this->oProduct->getCode(),
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
				
			$this->oProduct->delete();
			$oCon->commit();
			
			$this->info('succeed-product-deleted',
				array(
					$this->oProduct->getCode()
				)
			);
		}
		catch (Exception $oEx)
		{
			$oCon->rollBack();
						
			$this->error('failed-product-deleted',
				array(
					$this->oProduct->getCode(),
					$oEx->getCause()->getMessage()
				)
			);
			$this->errorHandler($oEx);
	  	}
		$this->oProduct = new Product();
		// $this->oProductDetail = new ProductDetail();
	}
	
	protected function doImport()
	{
		$sSaveAs='uploadfile_'.date('Y-m-d-H-i',time());
		$File=$this->processUpload('uploadfile','contents/'.$this->oApp->sDomain.'/csv/',array('csv'), $sSaveAs);

		if($File) 
		{
			$row = 1;
			$idx = 0;
			$result = array();
			if ($handle = fopen('contents/'.$this->oApp->sDomain.'/csv/'.$sSaveAs.'.csv', "r")) 
			{
				// echo "<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>";
				$aData = array();
				$aPrice = array();
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
				{
					$sSku = trim($data[0]);
					$sCategory = trim($data[1]);
					$sSubCategory = trim($data[2]);
					$sProduct = trim($data[3]);
					$sDetail = trim($data[4]);
					$iPrice = trim($data[5]);

					$oProductDetail = ProductDetailPeer::getBySku($sSku);
					if(!$oProductDetail instanceof ProductDetail && $sSku != '' && $sCategory != '' && $sSubCategory != '' && $sProduct != '' && $sDetail != '')
					{
						$oCategory = CategoryPeer::getByCode(Common::parseSaveURLString($sCategory));
						if(!$oCategory instanceof Category)
						{
							$oCategory = new Category();
							$oCategory->setCode(Common::parseSaveURLString($sCategory));
							$oCategory->setName($sCategory);
							$oCategory->save();
						}
						
						$oSubCategory = CategoryPeer::getByParentIdAndCode($oCategory->getId(), Common::parseSaveURLString($sCategory.'-'.$sSubCategory));
						if(!$oSubCategory instanceof Category)
						{
							$oSubCategory = new Category();
							$oSubCategory->setCode(Common::parseSaveURLString($sCategory.'-'.$sSubCategory));
							$oSubCategory->setName($sSubCategory);
							$oSubCategory->setParentId($oCategory->getId());
							$oSubCategory->save();
						}
						
						$oProduct = ProductPeer::getByCode(Common::parseSaveURLString($sProduct));
						if(!$oProduct instanceof Product)
						{
							$oProduct = new Product();
							$oProduct->setDate(Application::getFormalDateTime());
							$oProduct->setName($sProduct);
							$oProduct->setCode(Common::parseSaveURLString($sProduct));
							$oProduct->save();

							$oProductCategory = new ProductCategory();
							$oProductCategory->setProduct($oProduct);
							$oProductCategory->setCategory($oSubCategory);
							$oProductCategory->save();
						}
						
						if($oProduct instanceof Product)
						{
							$oProductDetail = ProductDetailPeer::getByPidAndSku($oProduct->getId(), $sSku);
							if(!$oProductDetail instanceof ProductDetail)
							{
								if($sProduct == $sDetail) $sName = $sDetail;
								else{
									$sName = str_replace($sProduct, '', $sDetail);
									$sName = trim($sName);
								} 
								$oProductDetail = new ProductDetail();
								$oProductDetail->setProduct($oProduct);
								$oProductDetail->setPrice($iPrice);
								$oProductDetail->setSku($sSku);
								$oProductDetail->setName($sName);
								$oProductDetail->setStock(1000);
								$oProductDetail->save();
							}
						}
						
					}
// 					
					// Common::printArray($data);
// 					
					// $json['json_'.$idx]['id'] = $data[0];
				    // $json['json_'.$idx]['product_id'] = $data[1];
				    // $json['json_'.$idx]['title'] = $data[2];
				    // $json['json_'.$idx]['outline'] = $data[3];     
// 					
				    // for ($i = 1, $j = count($data); $i < $j; $i++) {
				    	// // echo $data[$i]." ";	
					// }
				}
				fclose($handle);
			}
			// echo json_encode($json);
		}

	}
}
?>