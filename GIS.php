<?php
//
// +------------------------------------------------------------------------+
// | PEAR :: Image :: GIS                                                   |
// +------------------------------------------------------------------------+
// | Copyright (c) 2002-2003 Jan Kneschke <jan@kneschke.de> and             |
// |                         Sebastian Bergmann <sb@sebastian-bergmann.de>. |
// +------------------------------------------------------------------------+
// | This source file is subject to version 3.00 of the PHP License,        |
// | that is available at http://www.php.net/license/3_0.txt.               |
// | If you did not receive a copy of the PHP license and are unable to     |
// | obtain it through the world-wide-web, please send a note to            |
// | license@php.net so we can mail you a copy immediately.                 |
// +------------------------------------------------------------------------+
//
// $Id$
//

require_once 'Image/Color.php';
require_once 'Image/GIS/Parser.php';
require_once 'Image/GIS/Renderer.php';

/**
* ...
*
* The following example draws the region around the
* Germany city of Kiel which is Jan's home town:
*
*   <?php
*   require_once 'Image/GIS.php';
*
*   $map = new Image_GIS(960, 1280);
*   $map->setRange(9.7, 10.5, 54.2, 54.7);
*
*   $map->draw('germany_rdline.e00', 'gray');
*   $map->draw('germany_pppoly.e00', 'green');
*   $map->draw('germany_dnnet.e00',  'blue');
*   $map->draw('germany_ponet.e00',  'black');
*
*   $map->saveImage('kiel.png');
*   ?>
*
* @version  $Revision$
* @since    Image_GIS 1.0.0
*/
class Image_GIS {
    /**
    * Set to TRUE to enable debugging.
    *
    * @var boolean $debug
    */
    var $debug;

    /**
    * Image_GIS_Parser sub-class object.
    *
    * @var Image_GIS_Parser $parser
    */
    var $parser;

    /**
    * Image_GIS_Renderer sub-class object.
    *
    * @var Image_GIS_Renderer $renderer
    */
    var $renderer;

    /**
    * Constructor.
    *
    * @param  mixed   $width
    * @param  integer $height
    * @param  string  $parser
    * @param  string  $renderer
    * @param  boolean $debug
    * @access public
    */
    function Image_GIS($width, $height = -1, $parser = 'E00', $renderer = 'GD', $debug = false) {
        $this->debug = $debug;

        $this->setRenderer($renderer, $width, $height);
        $this->setParser($parser);
        $this->setRange(9, 11, 55, 54);
    }

    /**
    * Draws a datafile.
    *
    * @param  string  $dataFile
    * @param  mixed   $color
    * @return boolean
    * @access public
    */
    function draw($dataFile, $color) {
        return $this->parser->draw($dataFile, $color);
    }

    /**
    * Saves the rendered image to a given file.
    *
    * @param  string  $filename
    * @return boolean
    * @access public
    */
    function saveImage($filename) {
        return $this->renderer->saveImage($filename);
    }

    /**
    * Sets the Image_GIS_Parser sub-class to be used
    * to parse a data file.
    *
    * @param  string  $parser
    * @access public
    */
    function setParser($parser) {
        $this->parser = &Image_GIS_Parser::factory($parser, $this->renderer, $this->debug);
    }

    /**
    * Sets the range of the data to be rendered.
    *
    * @param  float $x1
    * @param  float $x2
    * @param  float $y1
    * @param  float $y2
    * @access public
    */
    function setRange($x1, $x2, $y1, $y2) {
        $this->renderer->setRange($x1, $x2, $y1, $y2);
    }

    /**
    * Sets the Image_GIS_Renderer sub-class to be used
    * to render an image.
    *
    * @param  string  $renderer
    * @access public
    */
    function setRenderer($renderer, $width, $height) {
        $this->renderer = &Image_GIS_Renderer::factory($renderer, $width, $height, $this->debug);
    }

    /**
    * Shows the rendered image.
    *
    * @access public
    */
    function showImage() {
        $this->renderer->showImage();
    }
}
?>
