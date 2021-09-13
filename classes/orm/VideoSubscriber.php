<?php

require 'orm/om/BaseVideoSubscriber.php';


/**
 * Skeleton subclass for representing a row from the 'video_subscriber' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class VideoSubscriber extends BaseVideoSubscriber {

	/**
	 * Initializes internal state of VideoSubscriber object.
	 * @see        parent::__construct()
	 */
	public function __construct()
	{
		// Make sure that parent constructor is always invoked, since that
		// is where any default values for this object are set.
		parent::__construct();
	}

} // VideoSubscriber
