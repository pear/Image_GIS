<?php
//
// +------------------------------------------------------------------------+
// | PEAR :: Image :: GIS :: Line Set                                       |
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
* A Set of Lines.
*
* @version  $Revision$
* @since    Image_GIS 1.0.1
*/
class Image_GIS_LineSet {
    /**
    * @var array $color
    */
    var $color = 'black';

    /**
    * @var array $lines
    */
    var $lines = array();

    /**
    * @var array $min
    */
    var $min = array(
      'x' => 0,
      'y' => 0
    );

    /**
    * @var array $max
    */
    var $max = array(
      'x' => 0,
      'y' => 0
    );

    /**
    * Constructor.
    *
    * @param  string $color
    * @access public
    */
    function Image_GIS_LineSet($color = 'black') {
        $this->color = $color;
    }

    /**
    * Adds a line to the line set.
    *
    * @param  float $x1
    * @param  float $y1
    * @param  float $x2
    * @param  float $y2
    * @access public
    */
    function addLine($x1, $y1, $x2, $y2) {
        $this->lines[] = array($x1, $y1, $x2, $y2);

        $this->min['x'] = min($this->min['x'], $x1, $x2);
        $this->min['y'] = min($this->min['y'], $y1, $y2);
        $this->max['x'] = max($this->max['x'], $x1, $x2);
        $this->max['y'] = max($this->max['y'], $y1, $y2);
    }
}
?>