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
    * Data Files.
    *
    * @var array $dataFiles
    */
    var $dataFiles = array();

    /**
    * Set to TRUE to enable debugging.
    *
    * @var boolean $debug
    */
    var $debug;

    /**
    * Lines.
    *
    * @var array $lines
    */
    var $lines = array();

    /**
    * Constructor.
    *
    * @param  boolean $debug
    * @access public
    */
    function Image_GIS_Parser($debug) {
        $this->debug = $debug;
    }

    /**
    * Factory.
    *
    * @param  string             $parser
    * @param  boolean            $debug
    * @return object
    * @access public
    */
    function &factory($parser, $debug) {
        include_once 'Image/GIS/Parser/' . $parser . '.php';

        $class = 'Image_GIS_Parser_' . $parser;
        return new $class($debug);
    }

    /**
    * Adds a datafile to the map.
    *
    * @param  string  $dataFile
    * @param  mixed   $color
    * @access public
    */
    function addDataFile($dataFile, $color) {
        $this->dataFiles[$dataFile] = $color;
    }

    /**
    * Parses the data files of the map.
    *
    * @access public
    * @return array
    */
    function parse() {
        foreach ($this->dataFiles as $dataFile => $color) {
            $this->parseFile($dataFile, $color);
        }

        return $this->lines;
    }

    /**
    * Parses a data file.
    *
    * @param  string  $dataFile
    * @param  mixed   $color
    * @access public
    * @abstract
    */
    function parseFile($dataFile, $color) { /* abstract */ }
}
?>