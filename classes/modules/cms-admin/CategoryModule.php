<?php
include_once 'AbstractAdminModule.php';

class CategoryModule extends AbstractAdminModule
{
	protected $oCategory;
	protected $oParentCategory;
	
	public function getName()
	{
		$sName = 'Category ';
		if($this->oCategory instanceof Category && !$this->oCategory->isNew())
			$sName .= ' : '.$this->oCategory->getName();
		return $sName;
	}
	
	public function init()
	{
		$this->oParentCategory = CategoryPeer::retrieveByPK(
				$this->oData->get('sub')
		);
		
		$this->oCategory = CategoryPeer::retrieveByPK(
			$this->oData->get('select',
				$this->oData->get('delete')
			)
		);
            
		if(!$this->oCategory instanceof Category)
		{
			$this->oCategory = new Category();
		}
		
		if($this->oParentCategory instanceof Category)
			$this->addLink('sub='.$this->oData->get('sub'));
		
		// $this->aContext['aTableColumn'] = is_array($this->oData->get('table_column')) ? $this->oData->get('table_column') : $this->oCategory->getTableColumnArray();
		// $this->aContext['sDate']= date('dmyHis');
	}
	
	public function ajaxHandler($sAjax)
	{
		switch($sAjax)
		{
			case 'form':
				if($this->oData->isExists('keywords')) $this->addLink('keywords='.urlencode($this->oData->get('keywords')));
				if($this->oData->isExists('save'))
					$this->doSave();
				$this->aContext['oCategory'] = $this->oCategory;
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
					$this->oCategory = CategoryPeer::retrieveByPK($id);
					
					if($this->oCategory instanceof Category)
					{
						$this->doDelete();
					}
				}
				$this->oCategory = new Category();
			}
		}
		$this->preparePage();
	}
	
	private function preparePage()
	{
		$this->regSortable(CategoryPeer::getFieldNames(BasePeer::TYPE_COLNAME));
		$this->aContext['oParentCategory'] = $this->oParentCategory;
		$this->aContext['aCategory'] = CategoryPeer::getByParent(
			$this->oParentCategory,
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
		$sName = Common::parseSaveURLString($this->oCategory->getName());
		if($this->oParentCategory instanceof Category)
			$sName = $this->oParentCategory->getCode().'-'.$sName;
		$this->oCategory->setCode($sName);
		
		$this->oCategory->setDescription($this->oData->get('description'));
		$aColumn = explode("\n", $this->oData->get('extra'));
		foreach ($aColumn as $sValue) {
			$aTemp[] = trim ($sValue);
		}
		$this->oCategory->setExtra(json_encode($aTemp));
		
		$this->doValidate($this->oCategory);
		if($_FILES['file']['name'])
		{
			$sFilename = $this->processUpload(
					'file',
					'contents/'.$this->oApp->sDomain.'/images/',
					explode(',',ConfigurationPeer::FILE_TYPE_IMAGE),
					null,
					false,
					true
			);
		}
		if($this->noError())
		{
			$oCon = $this->getCon();
			try
			{
				$oCon->beginTransaction();
				
				if($this->oParentCategory instanceof Category)
					$this->oCategory->setParentId($this->oParentCategory->getId());
				
				if($sFilename)
				{
					$sFile = 'contents/'.$this->oApp->sDomain.'/images/'.$this->oCategory->getPicture();
					if(is_file($sFile)) unlink($sFile);
				
					$this->oCategory->setPicture($sFilename);
				}
				if($this->oCategory->getIndex() === null) $this->oCategory->setIndex(0);
				
				$this->oCategory->setDescription($this->oData->get('description'));
				// $this->oCategory->setProductTableColumn(json_encode($this->oData->get('table_column')));
				
				$this->oCategory->save();
							
				$oCon->commit();

				$this->info('succeed-category-saved',
					array(
						$this->oCategory->getName()
					)
				);
				
				$this->oCategory = new Category();
			}
			catch (Exception $oEx)
			{
				$oCon->rollBack();
							
				$sFile = 'contents/'.$this->oApp->sDomain.'/images/'.$sFilename;
				if(is_file($sFile)) unlink($sFile);
				
				$this->error('failed-category-saved',
					array(
						$this->oCategory->getName(),
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
			
			$sFile = 'contents/'.$this->oApp->sDomain.'/images/'.$this->oCategory->getPicture();
			if(is_file($sFile)) unlink($sFile);
			
			$this->oCategory->delete();
			
			$oCon->commit();
			
			$this->info('succeed-category-deleted',
				array(
					$this->oCategory->getName()
				)
			);
		}
		catch (Exception $oEx)
		{
			$oCon->rollBack();
						
			$this->error('failed-category-deleted',
				array(
					$this->oCategory->getName(),
					$oEx->getCause()->getMessage()
				)
			);
			$this->errorHandler($oEx);
	  	}
		$this->oCategory = new Category();
	}
}
?>