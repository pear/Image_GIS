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

require_once 'Cache/Lite.php';
require_once 'Image/GIS/LineSet.php';

/**
* Parser Base Class.
*
* @version  $Revision$
* @since    Image_GIS 1.0.0
*/
class Image_GIS_Parser {
    /**
    * Cache.
    *
    * @var Cache_Lite $cache
    */
    var $cache = NULL;

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
    * Line Set.
    *
    * @var array $lineSets
    */
    var $lineSets = array();

    /**
    * Constructor.
    *
    * @param  boolean $cache
    * @param  boolean $debug
    * @access public
    */
    function Image_GIS_Parser($cache, $debug) {
        if ($cache) {
            $this->cache = new Cache_Lite;
        }

        $this->debug = $debug;
    }

    /**
    * Factory.
    *
    * @param  string  $parser
    * @param  boolean $cache
    * @param  boolean $debug
    * @return object
    * @access public
    */
    function &factory($parser, $cache, $debug) {
        include_once 'Image/GIS/Parser/' . $parser . '.php';

        $class = 'Image_GIS_Parser_' . $parser;
        return new $class($cache, $debug);
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
            $cacheID = md5($dataFile . '_' . $color);

            if (is_object($this->cache) &&
                $lineSet = $this->cache->get($cacheID, 'Image_GIS')) {
                $lineSet = unserialize($lineSet);
            } else {
                $lineSet = $this->parseFile($dataFile, $color);

                $this->cache->save(serialize($lineSet), $cacheID, 'Image_GIS');
            }

            $this->lineSets[] = $lineSet;
        }

        return $this->lineSets;
    }

    /**
    * Parses a data file.
    *
    * @param  string  $dataFile
    * @param  mixed   $color
    * @return mixed
    * @access public
    * @abstract
    */
    function parseFile($dataFile, $color) { /* abstract */ }
}
?>
