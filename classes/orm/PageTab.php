<?php

require 'orm/om/BasePageTab.php';


/**
 * Skeleton subclass for representing a row from the 'page_tab' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class PageTab extends BasePageTab {

	/**
	 * Initializes internal state of PageTab object.
	 * @see        parent::__construct()
	 */
	public function __construct()
	{
		// Make sure that parent constructor is always invoked, since that
		// is where any default values for this object are set.
		parent::__construct();
	}

} // PageTab
