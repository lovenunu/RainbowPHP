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
 * Class MemoryFileHandler
 * @package RainbowPHP\File
 * @author Benjamin Perche <bperche9@gmail.com>
 */
class MemoryFileHandler extends AbstractFileHandler
{
    protected $fileValue;
    protected $cursor;

    public function open($path = null, $mode = self::MODE_APPEND_AND_READ)
    {
        // Opening a new file only reset the current string
        $this->fileValue = "";
        $this->cursor = 0;
    }

    public function seek($offset, $whence = SEEK_SET)
    {
        if ($offset > $fileLen = strlen($this->fileValue)) {
            $offset = $fileLen;
        }

        $this->cursor = $offset;
    }

    public function end()
    {
        $this->seek(strlen($this->fileValue));
    }

    public function reset()
    {
        $this->cursor = 0;
    }

    protected function doWrite($message, $length)
    {
        $this->fileValue = substr_replace($this->fileValue, $message, $this->cursor);
    }

    public function readLine($length = null)
    {
        $buffer = "";
        $currentLoop = 0;

        while (isset($this->fileValue[$this->cursor]) && $this->fileValue[$this->cursor] != "\n") {
            if ($length === null || $currentLoop < $length) {
                $buffer .= $this->fileValue[$this->cursor];
            }

            $currentLoop++;
            $this->cursor++;
        }

        return $buffer;
    }

    public function read($length = null)
    {
        if ($length === null) {
            $length = strlen($this->fileValue) - $this->cursor;
        }

        $previousCursor = $this->cursor;
        $this->cursor += $length;

        return substr($this->fileValue, $previousCursor, $length);
    }
}
