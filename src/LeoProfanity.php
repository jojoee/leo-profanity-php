<?php

namespace Jojoee\Library;

/**
 * Class LeoProfanity
 * @package Jojoee\Library
 */
class LeoProfanity
{
    private $words = [];
    private $wordDictionary = [];

    /**
     * LeoProfanity constructor.
     */
    public function __construct()
    {
        $this->wordDictionary['default'] = file_get_contents('./dictionary.json');
        $this->words = $this->wordDictionary['default'];
    }
}
