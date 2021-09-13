<?php

class DefaultInterceptor extends AbstractInterceptor 

{

	public function doProcessInteceptor()

	{

		$oParam = new Parameter();

		$view = [

			# show latest news

			'latest_news' => NewsPeer::getByType('news', $oParam, null, -1, $oPager, 5),

			'services'	=> NewsPeer::getByType('service',$oParam),

			'interceptor' => $this

		];

		//dump(NewsPeer::getByType('service',$oParam));

		$this->handleSeo();

		$this->aContext += $view;

	}



	public function doUnSubscribe()

	{

		if($this->oData->isExists('unsub'))

		{

			$sEmail = $this->oData->get('unsub');

			$oSubscriber = SubscriberPeer::getByEmail($sEmail);

			if($oSubscriber instanceof Subscriber)

			{

				$oSubscriber->setActive(0);

				$oSubscriber->save();

				echo ('<script>alert(\'Success Unsubscribe !\')</script>');

			}

		}

	}



	public function limit_words($string, $word_limit)

	{

	  $words = explode(" ",$string);

	  return implode(" ",array_splice($words,0,$word_limit));

	}	

	

	public function handleSeo()

	{

		$oSeo = SeoPeer::getByUrl($_SERVER['REQUEST_URI']);

		$this->aContext['oSeo'] = $oSeo;

	}

	

	public function handleLanguage()

	{

		if($this->oData->isExists('lang'))

			$this->setSession('selectlanguage', $this->oData->get('lang'));

	}



	public function menu($omod = null, $menu = null, $class = "menuzord-menu") {

		if ($menu == null) {

			$menu = MenuPeer::getByGroup('main');

		}



		if (is_string($menu)) {

			$menu = MenuPeer::getByGroup($menu);

		}



		if (empty($menu)) {

			return;

		}



		$html = '<ul class="'.$class.'">';



		foreach ($menu as $item) {



			$submenu = $item->getSubMenu();

			$new_tab = $item->getNewTab() == 1 ? 'target="_blank"' : '';

			if ( count($submenu) > 0 ) {
				
				$html .= '<li>';

				$html .= 		'<a '. $new_tab .' href="'. $item->getUrl( $omod ) .'"><span>'. $item->getName() .'</span></a><span class="arrow">
                                <i></i>
                            </span>';

				$html .= $this->menu($omod, $submenu, "drop-menu bottom-right");

			}

			else {

				$html .= '<li>';

				$html .= 		'<a '. $new_tab .' href="'. $item->getUrl( $omod ) .'">'. $item->getName() .'</a>';

			}

			$html .= '</li>';



		}



		$html .= '</ul>';

		return $html;

	}



	public function services_menu($omod) {

		$menu = MenuPeer::getByParentId(3);

		return $this->menu($omod, $menu);

	}



	public function quick_menu($omod) {

		$menu = MenuPeer::getByGroup('quick');

		return $this->menu($omod, $menu);

	}



	public function gallery($code) {

		$gallery = GalleryPeer::getByCode($code);

		if ($gallery) {

			$pictures = $gallery->getPictures();

			return $pictures;

		}



		return [];

	}

}

?>