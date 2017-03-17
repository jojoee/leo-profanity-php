<?php

namespace Jojoee\Library;

/**
 * Class Util
 * @package Jojoee\Library
 */
class Util
{
    /**
     * Get all occurrences of needle in string
     *
     * @see http://stackoverflow.com/questions/7077455/how-to-find-position-of-a-character-in-a-string-in-php
     *
     * @example
     * getIndicesOf("le", "I learned to play the Ukulele in Lebanon.");
     * return [2, 25, 27, 33]
     *
     * @param string $needle
     * @param string $str lower string
     * @param integer $startIndex
     * @return integer[]
     */
    public function getIndicesOf($needle, $str, $startIndex = 0)
    {
        $indices = array();
        $index = $startIndex - 1;
        while (($index = strpos($str, $needle, $index + 1)) !== false) {
            $indices[] = $index;
        }

        return $indices;
    }
}
