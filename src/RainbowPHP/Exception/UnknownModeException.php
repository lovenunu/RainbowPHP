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

namespace RainbowPHP\Exception;

/**
 * Class UnknownModeException
 * @package RainbowPHP\Exception
 * @author Benjamin Perche <bperche9@gmail.com>
 */
class UnknownModeException extends \InvalidArgumentException
{
    public static function create($mode)
    {
        return new static(sprintf("The given mode '%s' is not valid", $mode));
    }
}
