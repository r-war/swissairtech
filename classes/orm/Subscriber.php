<?php

require 'orm/om/BaseSubscriber.php';


/**
 * Skeleton subclass for representing a row from the 'subscriber' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class Subscriber extends BaseSubscriber {

	/**
	 * Initializes internal state of Subscriber object.
	 * @see        parent::__construct()
	 */
	public function __construct()
	{
		// Make sure that parent constructor is always invoked, since that
		// is where any default values for this object are set.
		parent::__construct();
	}
	
	public function getActiveView()
	{
		if($this->getActive())
			return 'Yes';
		else
			return 'No';
	}

} // Subscriber
