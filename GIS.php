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
*   // Create new map.
*   $map = new Image_GIS(
*     'width'  =>  960,
*     'height' => 1280
*   );
*
*   // Political
*   $map->addDataFile('germany_ponet.e00',  'black');
*
*   // Roads
*   $map->addDataFile('germany_rdline.e00', 'gray');
*
*   // Populated Places
*   $map->addDataFile('germany_pppoly.e00', 'green');
*
*   // Drainage
*   $map->addDataFile('germany_dnnet.e00',  'blue');
*
*   // Set range to Kiel.
*   $map->setRange(9.7, 10.5, 54.2, 54.7);
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
    * @param  array   $parameters
    * @access public
    */
    function Image_GIS($parameters = array()) {
        $this->debug = isset($parameters['debug']) ? $parameters['debug'] : false;

        $this->setParser(
          isset($parameters['parser'])   ? $parameters['parser']   : 'E00',
          isset($parameters['cache'])    ? $parameters['cache']    : false,
          isset($parameters['cacheDir']) ? $parameters['cacheDir'] : '/tmp'
        );

        $this->setRenderer(
          isset($parameters['renderer']) ? $parameters['renderer'] : 'GD',
          isset($parameters['width'])    ? $parameters['width']    : 640,
          isset($parameters['height'])   ? $parameters['height']   : 480
        );
    }

    /**
    * Adds a datafile to the map.
    *
    * @param  string  $dataFile
    * @param  mixed   $color
    * @return boolean
    * @access public
    */
    function addDataFile($dataFile, $color) {
        return $this->parser->addDataFile($dataFile, $color);
    }

    /**
    * Returns the range of the data to be rendered.
    *
    * @return array
    * @access public
    * @since  Image_GIS 1.0.1
    */
    function getRange() {
        return $this->renderer->getRange();
    }

    /**
    * Renders the image.
    *
    * @access public
    */
    function render() {
        $this->renderer->render($this->parser->parse());
    }

    /**
    * Saves the rendered image to a given file.
    *
    * @param  string  $filename
    * @return boolean
    * @access public
    */
    function saveImage($filename) {
        $this->render();

        return $this->renderer->saveImage($filename);
    }

    /**
    * Sets the Image_GIS_Parser sub-class to be used
    * to parse a data file.
    *
    * @param  string  $parser
    * @param  boolean $cache
    * @access public
    */
    function setParser($parser, $cache) {
        $this->parser = &Image_GIS_Parser::factory($parser, $cache, $this->debug);
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
        $this->render();

        $this->renderer->showImage();
    }
}
?>
