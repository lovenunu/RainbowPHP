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

namespace RainbowPHP\Formatter;

use RainbowPHP\Formatter\Exception\BadFormattedStringException;

/**
 * Class LineFormatter
 * @package RainbowPHP\Formatter
 * @author Benjamin Perche <bperche9@gmail.com>
 */
class LineFormatter implements FormatterInterface
{
    public function format($value, $hashedValue)
    {
        return sprintf("%s,%s", $hashedValue, $value);
    }

    /**
     * @param $formattedValue
     * @return array                                                       The key is the real value, the value is the hash
     * @throws \RainbowPHP\Formatter\Exception\BadFormattedStringException if the given value is not valid
     */
    public function unformat($formattedValue)
    {
        if (!is_string($formattedValue) || (is_object($formattedValue) && !method_exists($formattedValue, "__toString"))) {
            throw new BadFormattedStringException(sprintf(
                "The given value is can't be handled, string expected, %s given",
                is_object($formattedValue) ? get_class($formattedValue) : gettype($formattedValue)
            ));
        }

        $data = explode(",", (string) $formattedValue, 2);

        if (count($data) !== 2) {
            throw BadFormattedStringException::create($formattedValue);
        }

        return [$data[1] => $data[0]];
    }
}
