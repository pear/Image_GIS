<?php
//
// +------------------------------------------------------------------------+
// | PEAR :: Image :: GIS :: SVG Renderer                                   |
// +------------------------------------------------------------------------+
// | Copyright (c) 2002-2003-2003 Jan Kneschke <jan@kneschke.de> and             |
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

require_once 'Image/GIS/Renderer.php';
require_once 'XML/Tree.php';

/**
* SVG Renderer.
*
* @version  $Revision$
* @since    Image_GIS 1.0.0
*/
class Image_GIS_Renderer_SVG extends Image_GIS_Renderer {
    /**
    * SVG Document.
    *
    * @var XML_Tree $svg
    */
    var $svg;

    /**
    * SVG Document Root.
    *
    * @var XML_Tree_Node $root
    */
    var $root;

    /**
    * Constructor.
    *
    * @param  mixed   $width
    * @param  integer $sizyY
    * @param  boolean $debug
    * @access public
    */
    function Image_GIS_Renderer_SVG($width, $height, $debug) {
        $this->Image_GIS_Renderer($width, $height, $debug);

        $this->svg  = new XML_Tree;
        $this->root = &$this->svg->addRoot(
          'svg',
          '',
          array(
            'width'  => $this->width,
            'height' => $this->height
          )
        );
    }

    /**
    * Draws a line from ($x1, $y1) to ($x2, $y2)
    * using the color rgb($r, $g, $b).
    *
    * @param  float   $x1
    * @param  float   $y1
    * @param  float   $x2
    * @param  float   $y2
    * @param  float   $r
    * @param  float   $g
    * @param  float   $b
    * @access public
    */
    function drawLine($x1, $y1, $x2, $y2, $r, $g, $b) {
        $line = &$this->root->addChild(
          'line',
          '',
          array(
            'x1'    => $x1,
            'y1'    => $y1,
            'x2'    => $x2,
            'y2'    => $y2,
            'style' => sprintf(
              'stroke:rgb(%s, %s, %s)',
              $r,
              $g,
              $b
            )
          )
        );
    }

    /**
    * Saves the rendered image to a given file.
    *
    * @param  string  $filename
    * @return boolean
    * @access public
    */
    function saveImage($filename) {
        if ($fp = @fopen($filename, 'w')) {
            @fputs($fp, $this->root->get());
            @fclose($fp);

            return true;
        }

        return false;
    }

    /**
    * Shows the rendered image.
    *
    * @access public
    */
    function showImage() {
        header('Content-Type: image/svg+xml');
        echo $this->root->get();
    }
}
?>
