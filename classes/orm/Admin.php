<?php

require 'orm/om/BaseAdmin.php';


/**
 * Skeleton subclass for representing a row from the 'admin' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class Admin extends BaseAdmin {

	/**
	 * Initializes internal state of Admin object.
	 * @see        parent::__construct()
	 */
	public function __construct()
	{
		// Make sure that parent constructor is always invoked, since that
		// is where any default values for this object are set.
		parent::__construct();
	}
	
	public function save(PropelPDO $con = null)
	{
		if($this->isNew() || $this->isColumnModified(AdminPeer::PASSWORD))
		{
			if(strlen($this->getPassword()) == 0)
			{
				$this->resetModified(AdminPeer::PASSWORD);
			}
			else
			{
				$this->setPassword(md5($this->getPassword()));
			}
		}
		return parent::save($con);
	}
	
	public function getPrivilegesArray()
	{
		$oAdminType = $this->getAdminType();
		$oAdminType->reload();
		if($oAdminType instanceof AdminType)
			return $oAdminType->getPrivilegesArray();
		else return array();
	}
	
	public function isAuthorized($aModule)
	{
		if(!is_array($aModule))
			$aModule = array($aModule);

		$bAuthorized = false;
		
		foreach($aModule as $sModule)
		{
			if(in_array($sModule, $this->getPrivilegesArray()))
			{
				$bAuthorized = $sModule;
				break;
			}
		}
		
		return $bAuthorized;
	}
	
} // Admin
