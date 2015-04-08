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
 * Class PHPCryptTransformer
 * @package RainbowPHP\Transformer
 * @author Benjamin Perche <benjamin@thelia.net>
 */
class PHPCryptTransformer implements TransformerInterface
{
    private $salt;

    public function __construct($salt = null)
    {
        $this->salt = $salt;
    }

    /**
     * @param  string $word
     * @return string The transformed string
     *
     * This method is called when a password has to be hashed
     */
    public function transform($word)
    {
        return crypt($word, $this->salt);
    }

    /**
     * @return string
     *
     * This method returns the transformer name
     */
    public function getName()
    {
        return "php_crypt";
    }

    /**
     * @param $value
     * @return bool
     *
     * Checks if the given value can be a hash of this type
     */
    public function canHaveBeenTransformedByMe($value)
    {
        return preg_match("/^\$1\$[a-z\d\.\/\$]+$/i", $value);
    }
}
