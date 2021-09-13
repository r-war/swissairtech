<?php
include_once 'AbstractCommonModule.php';
class ServicesModule extends AbstractCommonModule
{
  protected $oNews;
  public function init()
  {
    $this->oNews = NewsPeer::getByCode($this->oData->get('id'));
  }
  public function getName()
  {
    $sName = 'Services';
    if ($this->oNews instanceof News) 
      $sName = $this->oNews->getName();
    elseif ($this->oData->get('q'))
      $sName = 'News Search : ' . $this->oData->get('q');
    return $sName;
  }
  public function getMetaData($sType = 'title')
  {
    if ($this->oData->isExists('search'))
    {
      return parent::getMetaData($sType);
    }
    elseif ($this->oNews instanceof News)
    {
      switch ($sType)
      {
        case 'title':
          $sReturn = $this->oNews->getName();
          break;
        case 'keywords':
          $sReturn = implode(',', explode(' ', substr(strip_tags($this->oNews->getDescription()), 0, 200)));
          break;
        case 'description':
          $sReturn = strip_tags($this->oNews->getDescription());
          break;
      }
      return $sReturn;
    }
    else
      return parent::getMetaData($sType);
  }
  public function doBuildTemplate()
  {
    $this->aContext['news'] = $this->oNews;
    $this->aContext['news_list'] = NewsPeer::getByType('Service', $this->doHandleParameter(), null, $this->getPageList(), $oPager, 10);
    $this->regPageList($oPager);
  }
}
?>