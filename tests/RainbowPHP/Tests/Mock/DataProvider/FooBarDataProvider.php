<?php
/*************************************************************************************/
/* This file is part of the Thelia package.                                          */
/*                                                                                   */
/* Copyright (c) OpenStudio                                                          */
/* email : dev@thelia.net                                                            */
/* web : http://www.thelia.net                                                       */
/*                                                                                   */
/* For the full copyright and license information, please view the LICENSE.txt       */
/* file that was distributed with this source code.                                  */
/*************************************************************************************/

namespace RainbowPHP\Tests\Mock\DataProvider;

use RainbowPHP\DataProvider\DataProviderInterface;

/**
 * Class FooBarDataProvider
 * @package RainbowPHP\Tests\Mock\DataProvider
 * @author Benjamin Perche <benjamin@thelia.net>
 */
class FooBarDataProvider implements DataProviderInterface
{
    /**
     * @return mixed[]|\Iterator|\Generator Then current generated value
     *
     * It must return null when generation is finish
     */
    public function generate()
    {
        yield "foo";
        yield "bar";
        yield "baz";
    }
}
