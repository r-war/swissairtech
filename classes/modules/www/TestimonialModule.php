<?php
include_once 'AbstractCommonModule.php';

class TestimonialModule extends AbstractCommonModule
{
	protected $oTestimonial;
	
	public function isRedirect()
	{
		
	}

	public function getRedirectModule()
	{
    return array('','Default');
	}
	
	public function getName()
	{
		return "Testimonials";
	}
	
	public function getMetaData($sType = 'title')
	{
		if($this->oTestimonial instanceof Testimonial)
		{
			switch($sType)
			{
				case 'title' :
					$sReturn = $this->getName();
					break;
			}
			return $sReturn;			
		}
		else
			return parent::getMetaData($sType);
	}
	
	public function doBuildTemplate()
	{
		$categories = [
  		'auto-immune disease',
  		'cardiovascular problems',
  		'digestive',
  		'fatty liver & hepatitis',
  		'hair fall',
  		'insomnia',
  		'respiratory problems',
  		'skin problems',
  		'thyroid conditions',
  		'natural weight loss programme',
  		'woman\'s hormonal problems',
		];

		if (!isset($_GET['category'])) {
			$_GET['category'] = $categories[0];
		}

		$view = [
			#'categories' => $categories,
			'testimonials' => TestimonialPeer::getAll()
		];

		$this->aContext += $view;
		
		/*
		$oCrit = new Criteria();
		$oCrit->add(MenuPeer::TYPE, 2);
		$oCrit->add(MenuPeer::GROUP, 'main');
		$oCrit->add(MenuPeer::VALUE, $this->oPage->getId());
		$oMenu = MenuPeer::doSelectOne($oCrit);
		
		if($oMenu instanceof Menu)	
		{
			$oMenu = $oMenu->getMenuRelatedByParentId();
			$this->aContext['oParent'] = $oMenu;
		
			if($oMenu instanceof Menu)
			{
				while($oMenu->getParentId())
				{
					$oMenu = $oMenu->getMenuRelatedByParentId();
				}
			}
			$this->aContext['oAncestor'] = $oMenu;
		}
		*/
	}

	public function trim_words($content) {
		$html 	= "";
		$texts 	= str_word_count($content, 1);

		$i = 0;
		foreach ($texts as $text) {
			$html .= $text . " ";

			if ($i == 26) {
				$html .= '<a href="#" class="testimonial-readmore">Read more ></a> <span class="readmore-ellipsis">';
			}

			$i++;
		}

		$html .= '</span>';
		return $html;
	}
}
?>