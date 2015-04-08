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

use RainbowPHP\RainbowPHPFactory;
use RainbowPHP\RainbowPHPInterface;
use RainbowPHP\Transformer\Base64Transformer;
use RainbowPHP\Transformer\Md5Transformer;
use RainbowPHP\Transformer\MysqlPasswordTransformer;
use RainbowPHP\Transformer\PHPCryptTransformer;
use RainbowPHP\Transformer\Sha1Transformer;
use RainbowPHP\Transformer\UrlEncodeTransformer;

/**
 * Class RainbowPHPFactoryTest
 * @package RainbowPHP\Tests
 * @author Benjamin Perche <bperche9@gmail.com>
 */
class RainbowPHPFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var RainbowPHPFactory  */
    protected $factory;

    protected function setUp()
    {
        $this->factory = new RainbowPHPFactory();
    }

    public function testGeneratedRainbowPHPHasCoreTransformers()
    {
        $instance = $this->factory->create();

        $this->assertInstanceOf(RainbowPHPInterface::class, $instance);
        $this->assertInstanceOf(Md5Transformer::class, $instance->getTransformer("md5"));
        $this->assertInstanceOf(Sha1Transformer::class, $instance->getTransformer("sha1"));
        $this->assertInstanceOf(MysqlPasswordTransformer::class, $instance->getTransformer("mysql_password"));
        $this->assertInstanceOf(Base64Transformer::class, $instance->getTransformer("base64"));
        $this->assertInstanceOf(PHPCryptTransformer::class, $instance->getTransformer("php_crypt"));
        $this->assertInstanceOf(UrlEncodeTransformer::class, $instance->getTransformer("urlencode"));
    }
}
