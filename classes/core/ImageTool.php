<?php
include_once BASE_PATH . Attributes::CLASS_PATH . 'Image/Tools.php';

class ImageTool
{
	static function generateThumbnail($sFile, $sThumbFile, $aDimension=array(), Log $oLog = null, $bFixedSize = false)
	{
		$aImageData = getimagesize($sFile);
		if($oLog instanceof Log)
		{
			$oLog->info(
		    	'Generate Thumbnail: ' . $sThumbFile
		    );
		}
		$options = array(
		    'image'   => $sFile,
		    'width'   => (int) $aDimension[0],
		    'height'  => (int) $aDimension[1]
		);
		
		if($bFixedSize)
			$options['method'] = 1;
		
		// Create thumbnail object
		$thumbnail =& Image_Tools::factory('thumbnail', $options);
		if (PEAR::isError($thumbnail)) 
		{
			if($oLog instanceof Log)
			{
				$oLog->err(
			    	$thumbnail->toString()
			    );
			}
		}
		
		if($aImageData['mime'] == 'image/gif')
		{
			$iImageType = IMAGETYPE_GIF;
		}
		if($aImageData['mime'] == 'image/png')
		{
			$iImageType = IMAGETYPE_PNG;
		}
		else 
		{
			$iImageType = IMAGETYPE_JPEG;
		}

		$oErr = $thumbnail->save($sThumbFile,$iImageType);
		if (PEAR::isError($oErr)) 
		{
		    if($oLog instanceof Log)
			{
				$oLog->err(
			    	$thumbnail->toString()
			    );
			}
		}
	}	
}
?>