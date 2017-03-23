<?php

namespace Jojoee\Library;

/**
 * Class LeoProfanity
 * @package Jojoee\Library
 */
class LeoProfanity
{
    /** @var string[] */
    private $words = [];

    /** @var array */
    private $wordDictionary = [];

    /**
     * LeoProfanity constructor.
     *
     * @todo improve method for importing asset file
     */
    public function __construct()
    {
        $this->wordDictionary['default'] = include __DIR__ . '/dictionary/default.php';
        $this->words = $this->wordDictionary['default'];
    }

    /**
     * Remove word from the list
     *
     * @param string $str
     * @return LeoProfanity
     */
    private function removeWord($str)
    {
        $key = array_search($str, $this->words);
        if ($key !== false) {
            unset($this->words[$key]);
        }

        return $this;
    }

    /**
     * Add word into the list
     *
     * @param string $str
     * @return LeoProfanity
     */
    private function addWord($str)
    {
        $key = array_search($str, $this->words);
        if ($key === false) {
            $this->words[] = $str;
        }

        return $this;
    }

    /**
     * Return replacement word from key
     *
     * @example
     * getReplacementWord('*', 3)
     * return '***'
     *
     * @example
     * getReplacementWord('-', 4)
     * return '----'
     *
     * @param string $key
     * @param integer $nKeys
     * @return string
     */
    private function getReplacementWord($key, $nKeys)
    {
        $replacementWord = '';
        for ($i = 0; $i < $nKeys; $i++) {
            $replacementWord .= $key;
        }

        return $replacementWord;
    }

    /**
     * Get word dictionary
     * Now, we only have default dictionary
     *
     * @param string $dictionaryName
     * @return string[]
     */
    private function getDictionary($dictionaryName)
    {
        $result = [];
        if (array_key_exists($dictionaryName, $this->wordDictionary)) {
            $result = $this->wordDictionary[$dictionaryName];
        }

        return $result;
    }

    /**
     * Return all profanity words
     *
     * @return string[]
     */
    public function getList()
    {
        return $this->words;
    }

    /**
     * Sanitize string for this project
     * 1. Convert to lower case
     * 2. Replace comma and dot with space
     *
     * @param string $str
     * @return string
     */
    private function sanitize($str)
    {
        $str = strtolower($str);
        $str = preg_replace('/[,.]/', ' ', $str);

        return $str;
    }

    /**
     * Check the string contain profanity words or not
     * Approach, to make it fast ASAP
     *
     * @param string $str
     * @return boolean
     */
    public function check($str)
    {
        $isFound = false;
        if (!$str) return false;

        $str = $this->sanitize($str);
        $strs = explode(' ', $str);

        foreach ($this->words as $word) {
            if (in_array($word, $strs)) {
                $isFound = true;
                break;
            }
        }

        return $isFound;
    }

    /**
     * Replace profanity words
     *
     * @todo improve algorithm
     *
     * @param string $str
     * @param string $replaceKey one character only
     * @return string
     */
    public function clean($str, $replaceKey = '*')
    {
        if (!$str) return '';
        $originalString = $str;
        $result = $str;

        $sanitizedStr = $this->sanitize($originalString);
        // split by whitespace (keep delimiter)
        // (cause comma and dot already replaced by whitespace)
        $sanitizedArr = preg_split('/( )/', $sanitizedStr, 0, PREG_SPLIT_DELIM_CAPTURE);
        // split by whitespace, comma and dot (keep delimiter)
        $resultArr = preg_split('/( |,|\.)/', $result, 0, PREG_SPLIT_DELIM_CAPTURE);

        // loop through given string
        foreach ($sanitizedArr as $index => $value) {
            if (in_array($value, $this->words)) {
                $replacementWord = $this->getReplacementWord($replaceKey, strlen($value));
                $resultArr[$index] = $replacementWord;
            }
        }

        // combine it
        $result = implode('', $resultArr);

        return $result;
    }

    /**
     * Add word to the list
     *
     * @param string|string[] $data
     * @return LeoProfanity
     */
    public function add($data)
    {
        switch (gettype($data)) {
            case 'string':
                $this->addWord($data);
                break;
            case 'array':
                foreach ($data as $word) {
                    $this->addWord($word);
                }
                break;
            default:
                break;
        }

        return $this;
    }

    /**
     * Remove word from the list
     *
     * @param string|string[] $data
     * @return LeoProfanity
     */
    public function remove($data)
    {
        switch (gettype($data)) {
            case 'string':
                $this->removeWord($data);
                break;
            case 'array':
                foreach ($data as $word) {
                    $this->removeWord($word);
                }
                break;
            default:
                break;
        }

        return $this;
    }

    /**
     * Reset word list by using default dictionary (also remove word that manually add)
     *
     * @return LeoProfanity
     */
    public function reset()
    {
        $this->words = $this->getDictionary('default');

        return $this;
    }

    /**
     * Clear word list
     *
     * @return LeoProfanity
     */
    public function clearList()
    {
        $this->words = [];

        return $this;
    }
}
