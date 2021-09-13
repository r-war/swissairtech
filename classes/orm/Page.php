<?php



require 'orm/om/BasePage.php';





/**

 * Skeleton subclass for representing a row from the 'page' table.

 *

 * 

 *

 * You should add additional methods to this class to meet the

 * application requirements.  This class will only be generated as

 * long as it does not already exist in the output directory.

 *

 * @package    orm

 */

class Page extends BasePage {



	/**

	 * Initializes internal state of Page object.

	 * @see        parent::__construct()

	 */

	public function __construct()

	{

		// Make sure that parent constructor is always invoked, since that

		// is where any default values for this object are set.

		parent::__construct();

	}



	public function getPictureUrl()

	{

		$sFile = 'contents/'.$_SESSION[Attributes::SESSION_DOMAIN].'/images/'.$this->getPicture();

		if(is_file($sFile))

		{

			return '/'.$sFile;

		}

	}

	

	public function getUrl()

	{

		if(Attributes::REWRITE)

			return '/'.$this->getCode();//.'.html';

		else

			return '&id='.$this->getCode();

	}
	public function countSub()

	{

		$oCrit = new Criteria();

		$oCrit->add(pageTabPeer::PAGE_ID, $this->getId());

		return pageTabPeer::doCount($oCrit);

	}
	public function haveSub()

	{

		if($this->countSub() > 0) return true;

	}

} // Page

