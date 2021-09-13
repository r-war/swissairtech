<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 foldmethod=marker: */

// {{{ Header

/**
 * This is a driver file contains the Image_Tools_Swap class.
 *
 * PHP versions 4 and 5
 *
 * LICENSE:
 *
 * Copyright (c) 2005-2006 Firman Wandayandi <firman@php.net>
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted under the terms of the BSD License.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category    Images
 * @package     Image_Tools
 * @author      Firman Wandayandi <firman@php.net>
 * @copyright   Copyright (c) 2005-2006 Firman Wandayandi <firman@php.net>
 * @license     http://www.opensource.org/licenses/bsd-license.php
 *              BSD License
 * @version     CVS: $Id: Swap.php,v 1.2 2006/11/23 22:17:31 firman Exp $
 */

// }}}
// {{{ Dependencies

/**
 * Load Image_Tools as the base class.
 */
require_once 'Image/Tools.php';

/**
 * Load PHP_Compat for PHP5 backward compalitiby function (str_split())
 */
require_once 'PHP/Compat.php';

// load str_split() function
@PHP_Compat::loadFunction('str_split');

// }}}
// {{{ Class: Image_Tools_Swap

/**
 * This class provide masking tool for manipulating an image.
 *
 * @category    Images
 * @package     Image_Tools
 * @author      Firman Wandayandi <firman@php.net>
 * @copyright   Copyright (c) 2005-2006 Firman Wandayandi <firman@php.net>
 * @license     http://www.opensource.org/licenses/bsd-license.php
 *              BSD License
 * @version     Release: 0.4.2
 */
class Image_Tools_Swap extends Image_Tools
{
    // {{{ Properties

    /**
     * Swap options:
     * <pre>
     * image   mixed   Destination image, a filename or an image string
     *                 data or a GD image resource.
     * format  string  Destination color format (mix 'R', 'G', 'B'),
     *                 only 5 variations (RBG, BGR, BRG, GRB, GBR)
     * </pre>
     *
     * @var     array
     * @access  protected
     */
    var $options = array(
        'image'     => null,
        'format'    => 'RBG'
    );

    /**
     * Available options for Image_Tools_Swap.
     *
     * @var array
     * @access protected
     */
    var $availableOptions = array(
        'image'     => 'mixed',
        'format'    => 'string'
    );

    /**
     * Available methods for Image_Tool_Swap (only public methods).
     *
     * @var     array
     * @access  protected
     */
    var $availableMethods = array(
        'swapColor' => array(
            'format' => 'string',
            'rgb'    => 'array'
        )
    );

    /**
     * Image_Tools_Swap API version.
     *
     * @var     string
     * @access  protected
     */
    var $version = '0.1';

    // }}}
    // {{{ _init()

    /**
     * Initialize some internal variables.
     *
     * @return  bool|PEAR_Error TRUE on success or PEAR_Error on failure.
     * @access  private
     * @see     Image_Tools::createImage()
     */
    function _init()
    {
        $res = Image_Tools::createImage($this->options['image']);
        if (PEAR::isError($res)) {
            return $res;
        }
        $this->resultImage = $res;

        return true;
    }

    // }}}
    // {{{ render()

    /**
     * Apply swap color to image and output result.
     *
     * This function swap channel color 'R', 'G', 'B' to set format.
     *
     * @return  bool|PEAR_Error TRUE on success or PEAR_Error on failure.
     * @access  protected
     */
    function render()
    {
        $res = $this->_init();
        if (PEAR::isError($res)) {
            return $res;
        }

        if (!Image_Tools::isGDImageResource($this->resultImage)) {
            return PEAR::raiseError('Invalid image resource Image_Tools_Mask::$_resultImage');
        }

        if (!preg_match('@RBG|BGR|BRG|GRB|GBR$@i', $this->options['format'])) {
            return PEAR::raiseError('Invalid swap format');
        }

        $width = imagesx($this->resultImage);
        $height = imagesy($this->resultImage);
        $destImg = imagecreatetruecolor($width, $height);

        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                $index = imagecolorat($this->resultImage, $x, $y);
                $rgb = imagecolorsforindex($this->resultImage, $index);
                $rgb = Image_Tools_Swap::swapColor($this->options['format'], $rgb);
                $color = imagecolorallocate($destImg,
                                            $rgb['r'],
                                            $rgb['g'],
                                            $rgb['b']);
                imagesetpixel($destImg, $x, $y, $color);
            }
        }

        $this->resultImage = $destImg;
        return true;
    }

    // }}}
    // {{{ swapColor()

    /**
     * Swap RGB color channel.
     *
     * This function swap color channel array to given format,
     * e.g RGB->RBG mean red->red, green->blue and blue->green.
     *
     * @param   string $format Swap format, mix 'R', 'G' and 'B' to other string.
     * @param   array $rgb RGB color, an array contains keys
     *                     - red, green and blue, or
     *                     - r, g and b, or
     *                     - 0, 1 and 2
     *
     * @return  array|PEAR_Error Swapped color channel, an array contains
     *                           keys r, g and b on success or PEAR_Error
     *                           on failure.
     * @access  public
     */
    function swapColor($format, $rgb)
    {
        if (!is_array($rgb)) {
            return PEAR::raiseError('Type mismatch for argument 2');
        }

        $format = str_split(strtolower($format));

        if (isset($rgb['red']) && isset($rgb['green']) && isset($rgb['blue'])) {
            $color['r'] = $rgb['red'];
            $color['g'] = $rgb['green'];
            $color['b'] = $rgb['blue'];
        } elseif (isset($rgb['r']) && isset($rgb['g']) && isset($rgb['b'])) {
            $color = $rgb;
        } elseif (isset($rgb[0]) && isset($rgb[1]) && isset($rgb[2])) {
            $color['r'] = $rgb[0];
            $color['g'] = $rgb[1];
            $color['b'] = $rgb[2];
        } else {
            return PEAR::raiseError('Invalid RGB color');
        }

        return array(
            $format[0] => $color['r'],
            $format[1] => $color['g'],
            $format[2] => $color['b']
        );
    }

    // }}}
}

// }}}

/*
 * Local variables:
 * mode: php
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */
?>