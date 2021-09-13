<?php

include_once 'AbstractCommonModule.php';



class GalleryModule extends AbstractCommonModule

{

	public function init()

	{



	}



	public function getName()

	{

		$sName = 'Gallery';



		return $sName;

	}

	

	public function doBuildTemplate()

	{

		$this->aContext['aGallery'] = GalleryPeer::getByParent(

			// null,

			// $this->doHandleParameter(),

			// null,

			// $this->getPageList(),

			// $oPager,

			// 1

		);

		// $this->regPageList(

			// $oPager

			// );

	}

}

?>