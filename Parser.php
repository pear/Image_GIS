<?php
//
// +------------------------------------------------------------------------+
// | PEAR :: Image :: GIS :: Parser Base Class                              |
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

/**
* Parser Base Class.
*
* @version  $Revision$
* @since    Image_GIS 1.0.0
*/
class Image_GIS_Parser {
    /**
    * Set to TRUE to enable debugging.
    *
    * @var boolean $debug
    */
    var $debug;

    /**
    * Image_GIS_Renderer sub-class object.
    *
    * @var Image_GIS_Renderer $renderer
    */
    var $renderer;

    /**
    * Constructor.
    *
    * @param  Image_GIS_Renderer $renderer
    * @param  boolean            $debug
    * @access public
    */
    function Image_GIS_Parser(&$renderer, $debug) {
        $this->renderer = &$renderer;
        $this->debug    = $debug;
    }

    /**
    * Factory.
    *
    * @param  string             $parser
    * @param  Image_GIS_Renderer $renderer
    * @param  boolean            $debug
    * @return object
    * @access public
    */
    function &factory($parser, &$renderer, $debug) {
        include_once 'Image/GIS/Parser/' . $parser . '.php';

        $class = 'Image_GIS_Parser_' . $parser;
        return new $class($renderer, $debug);
    }
}
?>
