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

namespace RainbowPHP\DataProvider\Exception;

/**
 * Class InvalidArgumentException
 * @package RainbowPHP\DataProvider\Exception
 * @author Benjamin Perche <bperche9@gmail.com>
 */
class InvalidArgumentException extends \InvalidArgumentException
{
    public static function create($argumentName, $currentValue, $message = null)
    {
        $generatedMessage = sprintf("The value '%s' is not valid for argument %s", $currentValue, $argumentName);

        if (null !== $message) {
            $generatedMessage = sprintf("%s. %s", $generatedMessage, $message);
        }

        return new static($generatedMessage);
    }
}
