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

namespace RainbowPHP\Tests\Mock\Transformer;

use RainbowPHP\Transformer\TransformerInterface;

/**
 * Class FalseTransformerMock
 * @package RainbowPHP\Tests\Mock\Transformer
 * @author Benjamin Perche <benjamin@thelia.net>
 */
class FalseTransformerMock implements TransformerInterface
{
    /**
     * @param  string $word
     * @return string The transformed string
     *
     * This method is called when a password has to be hashed
     */
    public function transform($word)
    {
        return false;
    }

    /**
     * @return string
     *
     * This method returns the transformer name
     */
    public function getName()
    {
        return "false";
    }

    /**
     * @param $value
     * @return bool
     *
     * Checks if the given value can be a hash of this type
     */
    public function canHaveBeenHashedByMe($value)
    {
        return false;
    }
}
