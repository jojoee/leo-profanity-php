<?php
namespace Jojoee\Library\Tests;

use Jojoee\Library\Util;
use PHPUnit\Framework\TestCase;

class UtilTest extends TestCase
{
    /**
     * Test getIndicesOf
     */
    public function testGetIndicesOf()
    {
        $util = new Util();
        $this->assertEquals(
            $util->getIndicesOf('le', 'I learned to play the Ukulele in Lebanon.'),
            [2, 25, 27,]
        );
    }

    /**
     * Test getIndicesOf with startIndex param
     */
    public function testGetIndicesOfWithStartIndexParam()
    {
        $util = new Util();
        $this->assertEquals(
            $util->getIndicesOf('le', 'I learned to play the Ukulele in Lebanon.', 25),
            [25, 27,]
        );
    }
}
