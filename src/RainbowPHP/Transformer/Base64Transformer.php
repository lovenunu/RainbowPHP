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

namespace RainbowPHP\Transformer;


/**
 * Class Base64Transformer
 * @package RainbowPHP\Transformer
 * @author Benjamin Perche <benjamin@thelia.net>
 */
class Base64Transformer implements TransformerAndReverserInterface
{
    public function reverseTransformation($value)
    {
        return base64_decode($value);
    }

    public function canValueBeReversed($value)
    {
        return false !== $this->reverseTransformation($value);
    }

    /**
     * @param  string $word
     * @return string The transformed string
     *
     * This method is called when a password has to be hashed
     */
    public function transform($word)
    {
        return base64_encode($word);
    }

    /**
     * @return string
     *
     * This method returns the transformer name
     */
    public function getName()
    {
        return "base64";
    }

    /**
     * @param $value
     * @return bool
     *
     * Checks if the given value can be a hash of this type
     */
    public function canHaveBeenTransformedByMe($value)
    {
        return $this->canValueBeReversed($value);
    }
}
