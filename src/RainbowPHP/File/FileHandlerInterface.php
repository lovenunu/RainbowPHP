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
namespace RainbowPHP\File;

/**
 * Class FileHandler
 * @package RainbowPHP\File
 * @author Benjamin Perche <bperche9@gmail.com>
 */
interface FileHandlerInterface
{
    const MODE_READ_ONLY = "r";
    const MODE_READ_AND_WRITE = "r+";

    const MODE_ERASE_AND_WRITE_ONLY = "w";

    const MODE_APPEND = "a";
    const MODE_APPEND_AND_READ = "a+";

    const MODE_STRICT_CREATE_AND_WRITE_ONLY = "x";
    const MODE_STRICT_CREATE_AND_READ_AND_WRITE = "x+";

    const MODE_C_WRITE_ONLY = "c";
    const MODE_C_READ_AND_WRITE = "c+";

    const MOVE_LEFT = 0;
    const MOVE_RIGHT = 1;

    public function open($path, $mode = self::MODE_APPEND_AND_READ);

    public function seek($offset, $whence = SEEK_SET);

    public function end();

    public function reset();

    public function append($message, $length = null);

    public function write($message, $length = null);

    public function writeLine($message, $length = null);

    public function readLine($length = null);

    public function read($length = null);

    public function startTransaction();

    public function commit();

    public function rollback();
}
