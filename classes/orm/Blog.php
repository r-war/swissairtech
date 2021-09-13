<?php

require 'orm/om/BaseBlog.php';


/**
 * Skeleton subclass for representing a row from the 'blog' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class Blog extends BaseBlog {

	/**
	 * Initializes internal state of Blog object.
	 * @see        parent::__construct()
	 */
	public function __construct()
	{
		// Make sure that parent constructor is always invoked, since that
		// is where any default values for this object are set.
		parent::__construct();
	}

	public function getBlogs()
	{
		return PagePeer::getByParent($this);
	}
	
	public function getUrl()
	{
		if(Attributes::REWRITE)
			return '/'.$this->getCode().'.html';
		else
			return '&id='.$this->getCode();
	}
	
	public function getShortDescription()
	{
		$sReturn = '';
		$aDesc = explode('<p>', $this->getDescription());
		foreach($aDesc as $idx => $sDesc)
		{
			$sReturn .= '<p>'.$sDesc;
			if(count($sDesc) > 50 || $idx > 3) break;
		}
		
		return $sReturn;
	}
		
	public function getImage()
	{
		$sReturn = '';
		$aDesc = explode('<img', $this->getDescription());
		$sDesc = $aDesc[1];
		$aDesc = explode('src', $sDesc);
		$sDesc = $aDesc[1];
		$aDesc = explode('"', $sDesc);
		$sDesc = $aDesc[1];
		
		return $sDesc;
	}
	
	public function getPrev()
	{
		$aBlog = BlogPeer::getAll();
		foreach ($aBlog as $idx => $oBlog)
		{
			if($oBlog->getId() == $this->getId())
			{
				$iPrev = $idx+1;
				break;
			}
		}
		return $aBlog[$iPrev];
	}
	
	public function getNext()
	{
		$aBlog = BlogPeer::getAll();
		foreach ($aBlog as $idx => $oBlog)
		{
			if($oBlog->getId() == $this->getId())
			{
				$iNext = $idx-1;
				break;
			}
		}
		return $aBlog[$iNext];
	}
	
	public function countSameMonth()
	{
		return BlogPeer::countSameMonth($this);
	}
	
	
} // Blog
