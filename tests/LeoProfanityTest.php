<?php

namespace Jojoee\Library\Tests;

use Jojoee\Library\LeoProfanity;
use PHPUnit\Framework\TestCase;

class LeoProfanityTest extends TestCase
{
    /**
     * Test getList
     */
    public function testGetIndicesOf()
    {
        $filter = new LeoProfanity();

        $this->assertContains('boob', $filter->getList());
    }

    /**
     * Test check
     */
    public function testCheck()
    {
        $filter = new LeoProfanity();

        // no bad word
        $this->assertFalse($filter->check('I have 2 eyes'));

        // normal case
        $this->assertTrue($filter->check('2g1c'));

        // first & last
        $this->assertTrue($filter->check('zoophilia'));
        $this->assertTrue($filter->check('lorem 2g1c ipsum'));
        $this->assertTrue($filter->check('lorem zoophilia ipsum'));
        $this->assertTrue($filter->check('I have boob, etc.'));
    }

    /**
     * Test check by empty string
     */
    public function testCheckEmptyString()
    {
        $filter = new LeoProfanity();

        $this->assertFalse($filter->check(''));
    }

    /**
     * Test check with case sensitive
     */
    public function testCheckWithCaseSensitive()
    {
        $filter = new LeoProfanity();

        $this->assertTrue($filter->check('I have BoOb'));
    }

    /**
     * Test check with comma and dot
     */
    public function testCheckWithCommaAndDot()
    {
        $filter = new LeoProfanity();

        $this->assertTrue($filter->check('I have BoOb,'));
        $this->assertTrue($filter->check('I have BoOb.'));
    }

    /**
     * Test check multi-occurrence
     */
    public function testCheckMultiOccurrence()
    {
        $filter = new LeoProfanity();

        $this->assertTrue($filter->check('I have boob,boob, ass, and etc.'));
    }

    /**
     * Test check unspaced word
     */
    public function testCheckUndetectedUnspacedWord()
    {
        $filter = new LeoProfanity();

        $this->assertFalse($filter->check('Buy classic watches online'));
    }

    /**
     * Test clean
     */
    public function testClean()
    {
        $filter = new LeoProfanity();

        // no bad word
        $this->assertEquals($filter->clean('I have 2 eyes'), 'I have 2 eyes');

        // normal case
        $this->assertEquals($filter->clean('I have boob, etc.'), 'I have ****, etc.');

        // first & last
        $this->assertEquals($filter->clean('2g1c'), '****');
        $this->assertEquals($filter->clean('zoophilia'), '*********');
        $this->assertEquals($filter->clean('lorem 2g1c ipsum'), 'lorem **** ipsum');
        $this->assertEquals($filter->clean('lorem zoophilia ipsum'), 'lorem ********* ipsum');
    }

    /**
     * Test clean by empty string
     */
    public function testCleanEmptyString()
    {
        $filter = new LeoProfanity();

        $this->assertEquals($filter->clean(''), '');
    }

    /**
     * Test clean with case sensitive
     */
    public function testCleanWithCaseSensitive()
    {
        $filter = new LeoProfanity();

        $this->assertEquals($filter->clean('I have BoOb'), 'I have ****');
    }

    /**
     * Test clean with comma and dot
     */
    public function testCleanWithCommaAndDot()
    {
        $filter = new LeoProfanity();

        $this->assertEquals($filter->clean('I have BoOb,'), 'I have ****,');
        $this->assertEquals($filter->clean('I have BoOb.'), 'I have ****.');
    }

    /**
     * Test clean multi-occurrence
     */
    public function testCleanMultiOccurrence()
    {
        $filter = new LeoProfanity();

        $this->assertEquals($filter->clean('I have boob,boob, ass, and etc.'), 'I have ****,****, ***, and etc.');
    }

    /**
     * Test clean unspaced word
     */
    public function testCleanUndetectedUnspacedWord()
    {
        $filter = new LeoProfanity();

        $this->assertEquals($filter->clean('Buy classic watches online'), 'Buy classic watches online');
    }

    /**
     * Test clean with custom replaceKey
     */
    public function testCleanWithCustomReplaceKey()
    {
        $filter = new LeoProfanity();

        $this->assertEquals($filter->clean('I have boob', '+'), 'I have ++++');
    }

    /**
     * Test clean multi space
     */
    public function testCleanMultiSpace()
    {
        $filter = new LeoProfanity();

        $this->assertEquals($filter->clean('I  hav   ,e BoOb,  '), 'I  hav   ,e ****,  ');
        $this->assertEquals($filter->clean(',I h  a.   v e BoOb.'), ',I h  a.   v e ****.');
    }

    /**
     * Test add by string
     */
    public function testAddByString()
    {
        $filter = new LeoProfanity();
        $filter->add('b00b');

        $this->assertContains('b00b', $filter->getList());
    }

    /**
     * Test add by array
     */
    public function testAddByArray()
    {
        $filter = new LeoProfanity();
        $filter->add(['b@@b', 'b##b']);

        $this->assertContains('b@@b', $filter->getList());
        $this->assertContains('b##b', $filter->getList());
    }

    /**
     * Test add duplicate word
     * it should not add duplicate word
     */
    public function testAddDuplicateWord()
    {
        $filter = new LeoProfanity();
        $filter->add(['b@@b', 'b##b']);
        $numberOfCurrentWords = count($filter->getList());
        $filter->add(['b@@b', 'b##b']);

        $this->assertEquals(count($filter->getList()), $numberOfCurrentWords);
    }

    /**
     * Test remove by string
     */
    public function testRemoveByString()
    {
        $filter = new LeoProfanity();
        $filter->remove('boob');

        $this->assertNotContains('boob', $filter->getList());
    }

    /**
     * Test remove by array
     */
    public function testRemoveByArray()
    {
        $filter = new LeoProfanity();
        $filter->remove(['boob', 'boobs']);

        $this->assertNotContains('boob', $filter->getList());
        $this->assertNotContains('boobs', $filter->getList());
    }

    public function testReset()
    {
        $filter = new LeoProfanity();
        $numberOfCurrentWords = count($filter->getList());
        $filter->add(['badword1', 'badword2']);
        $filter->reset();

        $this->assertEquals(count($filter->getList()), $numberOfCurrentWords);
    }

    public function testClearList()
    {
        $filter = new LeoProfanity();
        $filter->clearList();
        $this->assertEmpty($filter->getList());
    }
}
