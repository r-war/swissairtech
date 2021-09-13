<?php

require 'orm/om/BaseTestimonial.php';


/**
 * Skeleton subclass for representing a row from the 'testimonial' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class Testimonial extends BaseTestimonial {

	/**
	 * Initializes internal state of Testimonial object.
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
	
	public function getName($sLang = 'en')
 	{
 		if(!$sLang)
 			return parent::getName();
 		else
 		{
 			$sDesc = parent::getName();
 			$aDesc = json_decode($sDesc,true);
 			if(is_array($aDesc))
	 			return $aDesc[$sLang];
			else 
				return parent::getName();
 		}
 	}
 	public function getPictureUrl(){
 		$sFile='contents/'.$_SESSION[Attributes::SESSION_DOMAIN].'/images/'.$this->getPicture();
 		if(is_file($sFile))
 			return '/'.$sFile;
 	}
 	public function setName($sDesc, $sLang = 'en')
 	{
 		if(!$sLang)
 			parent::setName($sDesc);
 		else
 		{
 			$sAllDesc = parent::getName();
 			$aDesc = json_decode($sAllDesc,true);
 			if(!is_array($aDesc)) $aDesc = array();
 			$aDesc[$sLang] = $sDesc;
 			
 			parent::setName(json_encode($aDesc));
 		}
 	}
	
 	public function getDescription($sLang = 'en')
 	{
 		if(!$sLang)
 			return parent::getDescription();
 		else
 		{
 			$sDesc = parent::getDescription();
 			$aDesc = json_decode($sDesc,true);
 			if(is_array($aDesc))
	 			return $aDesc[$sLang];
			else 
				return parent::getDescription();
 		}
 	}
 	
 	public function setDescription($sDesc, $sLang = 'en')
 	{
 		if(!$sLang)
 			parent::setDescription($sDesc);
 		else
 		{
 			$sAllDesc = parent::getDescription();
 			$aDesc = json_decode($sAllDesc,true);
 			if(!is_array($aDesc)) $aDesc = array();
 			$aDesc[$sLang] = $sDesc;
 			
 			parent::setDescription(json_encode($aDesc));
 		}
 	}

} // Testimonial
