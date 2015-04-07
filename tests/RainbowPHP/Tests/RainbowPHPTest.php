<?php
/*************************************************************************************/
/* This file is part of the RainbowPHP package. If you think this file is lost,      */
/* please send it to anyone kind enough to take care of it. Thank you.               */
/*                                                                                   */
/* email : bperche9@gmail.com                                                        */
/* web : http://www.benjaminperche.fr                                                */
/*                                                                                   */
/* For the full copyright and license information, please view the LICENSE.txt       */
/* file that was distributed with this source code.                                  */
/*************************************************************************************/

namespace RainbowPHP\Tests;

use RainbowPHP\File\MemoryFileHandler;
use RainbowPHP\RainbowPHP;
use RainbowPHP\RainbowPHPInterface;
use RainbowPHP\Tests\Mock\Transformer\FalseTransformerMock;
use RainbowPHP\Tests\Mock\Transformer\TrueTransformerMock;

/**
 * Class RainbowPHPTest
 * @package RainbowPHP\Tests
 * @author Benjamin Perche <bperche9@gmail.com>
 */
class RainbowPHPTest extends RainbowPHPVfsTestCase
{
    /** @var RainbowPHP */
    protected $rainbow;

    protected function setUp()
    {
        parent::setUp();

        $this->rainbow = new RainbowPHP();
    }

    public function testGuessHashTransformer()
    {
        $falseTransformer = new FalseTransformerMock();
        $trueTransformer = new TrueTransformerMock();

        $this->rainbow->addTransformer($falseTransformer);
        $this->assertCount(1, $this->rainbow->allTransformers());

        $this->assertCount(0, $this->rainbow->guessHashTransformer("foo"));

        $this->rainbow->addTransformer($falseTransformer, "foo");
        $this->assertCount(2, $this->rainbow->allTransformers());

        $this->assertCount(0, $this->rainbow->guessHashTransformer("foo"));

        $this->rainbow->addTransformer($trueTransformer);
        $this->assertCount(3, $this->rainbow->allTransformers());
        $this->assertCount(1, $this->rainbow->guessHashTransformer("foo"));
    }

    public function testLookupHash()
    {
        $rainbow = new MemoryFileHandler();
        $rainbow->write("foo,bar\nbar,baz\nfoo,baz");

        $rainbow->reset();
        $this->assertCount(0, $this->rainbow->lookupHash($rainbow, "orange"));

        $rainbow->reset();
        $this->assertEquals(["baz" => "bar"], $this->rainbow->lookupHash($rainbow, "bar"));

        $rainbow->reset();
        $this->assertEquals(["bar" => "foo"], $this->rainbow->lookupHash($rainbow, "foo"));

        $rainbow->reset();
        $this->assertEquals(
            ["bar" => "foo", "baz" => "foo"],
            $this->rainbow->lookupHash($rainbow, "foo", RainbowPHPInterface::LOOKUP_MODE_DEEP)
        );
    }
}
