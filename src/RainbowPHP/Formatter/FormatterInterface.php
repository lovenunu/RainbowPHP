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

/**
 * Class LineFormatter
 * @package RainbowPHP\Formatter
 * @author Benjamin Perche <bperche9@gmail.com>
 */
interface FormatterInterface
{
    /**
     * @param $value
     * @param $hashedValue
     * @return string The formatted string for the two values
     */
    public function format($value, $hashedValue);

    /**
     * @param $formattedValue
     * @return array                                                       The key is the real value, the value is the hash
     * @throws \RainbowPHP\Formatter\Exception\BadFormattedStringException if the given value is not valid
     */
    public function unformat($formattedValue);
}
