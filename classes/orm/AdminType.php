<?php

require 'orm/om/BaseAdminType.php';


/**
 * Skeleton subclass for representing a row from the 'admin_type' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class AdminType extends BaseAdminType {

	/**
	 * Initializes internal state of AdminType object.
	 * @see        parent::__construct()
	 */
	public function __construct()
	{
		// Make sure that parent constructor is always invoked, since that
		// is where any default values for this object are set.
		parent::__construct();
	}

	public function getPrivilegesArray()
	{
		if($this->getPrivileges() != '')
			return json_decode($this->getPrivileges());
		else return array();
	}
} // AdminType
