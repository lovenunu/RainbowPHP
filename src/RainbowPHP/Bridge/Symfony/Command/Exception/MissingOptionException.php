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
/*************************************************************************************/
/* This file is part of the RainbowPHP package. If you think this file is lost,      */
/* please send it to anyone kind enough to take care of it. Thank you                */
/*                                                                                   */
/* email : bperche9@gmail.com                                                        */
/* web : http://www.benjaminperche.fr                                                */
/*                                                                                   */
/* For the full copyright and license information, please view the LICENSE.txt       */
/* file that was distributed with this source code.                                  */
/*************************************************************************************/

namespace RainbowPHP\Bridge\Symfony\Command\Exception;

/**
 * Class MissingOptionException
 * @package RainbowPHP\Bridge\Symfony\Command\Exception
 * @author Benjamin Perche <bperche9@gmail.com>
 */
class MissingOptionException extends \InvalidArgumentException
{
    public static function create($missingOptions)
    {
        if (!is_array($missingOptions)) {
            $missingOptions = [$missingOptions];
        }

        return new static(sprintf(
            "The following option is missing: %s",
            implode(" or ", $missingOptions)
        ));
    }
}
