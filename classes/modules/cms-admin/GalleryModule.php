<?php
include_once 'AbstractAdminModule.php';
class GalleryModule extends AbstractAdminModule
{
  protected $oGallery;
  protected $oParentGallery;
  public function getName()
  {
    $sName = 'Gallery ';
    if ($this->oGallery instanceof Gallery && !$this->oGallery->isNew())
      $sName .= ' : ' . $this->oGallery->getName();
    return $sName;
  }
  public function init()
  {
    $this->oParentGallery = GalleryPeer::retrieveByPK($this->oData->get('sub'));
    $this->oGallery       = GalleryPeer::retrieveByPK($this->oData->get('select', $this->oData->get('delete')));
    if (!$this->oGallery instanceof Gallery) {
      $this->oGallery = new Gallery();
    }
    if ($this->oParentGallery instanceof Gallery)
      $this->addLink('sub=' . $this->oData->get('sub'));
    // $this->aContext['aTableColumn'] = is_array($this->oData->get('table_column')) ? $this->oData->get('table_column') : $this->oGallery->getTableColumnArray();
    // $this->aContext['sDate']= date('dmyHis');
  }
  public function ajaxHandler($sAjax)
  {
    switch ($sAjax) {
      case 'form':
        if ($this->oData->isExists('save'))
          $this->doSave();
        $this->aContext['oGallery'] = $this->oGallery;
        break;
    }
  }
  public function doBuildTemplate()
  {
    if ($this->oData->isExists('delete')) {
      $this->doDelete();
    } else if ($this->oData->isExists('deleteChecked')) {
      if (is_array($this->oData->get('c'))) {
        foreach ($this->oData->get('c') as $id) {
          $this->oGallery = GalleryPeer::retrieveByPK($id);
          if ($this->oGallery instanceof Gallery) {
            $this->doDelete();
          } else {
            $this->oGallery = new Gallery();
          }
        }
      }
    }
    $this->preparePage();
  }
  private function preparePage()
  {
    $this->regSortable(GalleryPeer::getFieldNames(BasePeer::TYPE_COLNAME));
    $this->aContext['oParentGallery'] = $this->oParentGallery;
    $this->aContext['aGallery']       = GalleryPeer::getByParent($this->oParentGallery, $this->doHandleParameter(), $this->getSortable(), $this->getPageList(), $oPager);
    $this->regPageList($oPager);
  }
  private function doSave()
  {
    $sName = $this->oData->get('name');
    if ($this->oParentGallery instanceof Gallery)
      $sName = ' ' . $this->oParentGallery->getName() . ' ' . $sName;

		$this->oGallery->setName($sName);
		$this->oGallery->setDescription($this->oData->get('description'));
    $this->oGallery->setCode(Common::parseSaveURLString($sName));
    // $aColumn = explode("\n", $this->oData->get('extra'));
    // foreach ($aColumn as $sValue) {
    // $aTemp[] = trim ($sValue);
    // }
    // $this->oGallery->setExtra(json_encode($aTemp));
    /*
    $this->doValidate($this->oGallery);
    if ($_FILES['file']['name']) {
      $sFilename = $this->processUpload('file', 'contents/' . $this->oApp->sDomain . '/images/', explode(',', ConfigurationPeer::FILE_TYPE_IMAGE), null, false, true);
    }
    */
    if ($this->noError()) {
      $oCon = $this->getCon();
      try {
        $oCon->beginTransaction();
        if ($this->oParentGallery instanceof Gallery)
          $this->oGallery->setParentId($this->oParentGallery->getId());
        /*
        if ($sFilename) {
          $sFile = 'contents/' . $this->oApp->sDomain . '/images/' . $this->oGallery->getPicture();
          if (is_file($sFile))
            unlink($sFile);
          $this->oGallery->setPicture($sFilename);
        }
        */
        if ($this->oGallery->getIndex() === null)
          $this->oGallery->setIndex(0);
        // $this->oGallery->setDescription($this->oData->get('description'));
        // $this->oGallery->setProductTableColumn(json_encode($this->oData->get('table_column')));
        $this->oGallery->save();
        $oCon->commit();
        $this->info('succeed-gallery-saved', array(
          $this->oGallery->getName()
        ));
      }
      catch (Exception $oEx) {
        $oCon->rollBack();
        /*
        $sFile = 'contents/' . $this->oApp->sDomain . '/images/' . $sFilename;
        if (is_file($sFile))
          unlink($sFile);
        */
        $this->error('failed-gallery-saved', array(
          $this->oGallery->getName(),
          $oEx->getMessage()
        ));
        $this->errorHandler($oEx);
      }
      $this->oGallery = new Gallery();
    }
  }
  private function doDelete()
  {
    $oCon = $this->getCon();
    try {
      $oCon->beginTransaction();
      /*
      $sFile = 'contents/' . $this->oApp->sDomain . '/images/' . $this->oGallery->getPicture();
      if (is_file($sFile))
        unlink($sFile);
      */
      $this->oGallery->delete();
      $oCon->commit();
      $this->info('succeed-gallery-deleted', array(
        $this->oGallery->getName()
      ));
    }
    catch (Exception $oEx) {
      $oCon->rollBack();
      $this->error('failed-gallery-deleted', array(
        $this->oGallery->getName(),
        $oEx->getCause()->getMessage()
      ));
      $this->errorHandler($oEx);
    }
    $this->oGallery = new Gallery();
  }
}
?>