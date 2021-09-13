<?php

include_once 'AbstractAdminModule.php';

class AdminTypeModule extends AbstractAdminModule

{

  protected $oAdminType;

  protected $aPrivileges;

  public function getName()

  {

    $sName = 'Admin Type ';

    if ($this->oAdminType instanceof AdminType && !$this->oAdminType->isNew())

      $sName .= ' : ' . $this->oAdminType->getName();

    return $sName;

  }

  public function init()

  {

    $this->oAdminType = AdminTypePeer::retrieveByPK($this->oData->get('select', $this->oData->get('delete')));

    if (!$this->oAdminType instanceof AdminType)

      $this->oAdminType = new AdminType();

    $this->aPrivileges = array(

      'User' => array(

        'AdminType' => 'Admin Type / Privileges',

        'Admin' => 'Admin',

        'Testimonial' => 'User Testimonial'

        /*, 'User' => 'Member', 'Subscriber' => 'Mailing List', 'Testimonial' => 'User Testimonial'*/

      ),

      // 'database' => array('Subscriber' => 'mailing_list'),

      'Content' => array(

        'Menu' => 'Menu',

        'Page' => 'Page Content',

        'Content' => 'Content',

        'News'	=> 'News', /*, 'News' => 'News'/*,'Service' => 'Service' ,*/

        'Seo' => 'SEO'

        /*,'Event' => 'Event'*/

      ),

      'Picture ' => array(

        'Banner' => 'Banner',

        //'Gallery' => 'Gallery'

      ),

      // 'Property' => array('Category' => 'Category', 'Product' => 'Property', 'ProductUser' => 'Assign Property'/*, 'Featured' => 'Featured Product', 'Promo' => 'Promotions'*/),

      // 'Order' => array('Order' => 'Order'),

      'Configuration' => array(

        'Configuration' => 'Configuration'

      )

    );

  }

  public function ajaxHandler($sAjax)

  {

    switch ($sAjax) {

      case 'form':

        if ($this->oData->isExists('keywords'))

          $this->addLink('keywords=' . urlencode($this->oData->get('keywords')));

        if ($this->oData->isExists('save'))

          $this->doSave();

        $this->aContext['oAdminType']         = $this->oAdminType;

        $this->aContext['aCheckedPrivileges'] = is_array($this->oData->get('privileges')) ? $this->oData->get('privileges') : $this->oAdminType->getPrivilegesArray();

        $this->aContext['aPrivileges']        = $this->aPrivileges;

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

          $this->oAdminType = AdminTypePeer::retrieveByPK($id);

          if ($this->oAdminType instanceof AdminType) {

            $this->doDelete();

          }

        }

        $this->oAdminType = new AdminType();

      }

    }

    $this->preparePage();

  }

  private function preparePage()

  {

    $this->regSortable(AdminTypePeer::getFieldNames(BasePeer::TYPE_COLNAME));

    $this->aContext['aAdminType'] = AdminTypePeer::getAll($this->doHandleParameter(), $this->getSortable(), $this->getPageList(), $oPager);

    $this->regPageList($oPager);

  }

  private function doSave()

  {

    $this->doValidate($this->oAdminType);

    if ($this->noError()) {

      $oCon = $this->getCon();

      try {

        $oCon->beginTransaction();

        $this->oAdminType->setPrivileges(json_encode($this->oData->get('privileges')));

        $this->oAdminType->save();

        $oCon->commit();

        $this->info('succeed-admin_type-saved', array(

          $this->oAdminType->getName()

        ));

        $this->oAdminType = new AdminType();

      }

      catch (Exception $oEx) {

        $oCon->rollBack();

        $this->error('failed-admin_type-saved', array(

          $this->oAdminType->getName(),

          $oEx->getMessage()

        ));

        $this->errorHandler($oEx);

      }

    }

  }

  private function doDelete()

  {

    $oCon = $this->getCon();

    try {

      $oCon->beginTransaction();

      $this->oAdminType->delete();

      $oCon->commit();

      $this->info('succeed-admin_type-deleted', array(

        $this->oAdminType->getName()

      ));

    }

    catch (Exception $oEx) {

      $oCon->rollBack();

      $this->error('failed-admin_type-deleted', array(

        $this->oAdminType->getName(),

        $oEx->getCause()->getMessage()

      ));

      $this->errorHandler($oEx);

    }

    $this->oAdminType = new AdminType();

  }

}

?>