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
        $this->wordDictionary['default'] = include __DIR__ . '/dictionary/default.php';
        $this->words = $this->wordDictionary['default'];
    }
}
