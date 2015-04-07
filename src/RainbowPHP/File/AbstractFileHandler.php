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

use RainbowPHP\File\Exception\FileHandlerException;

/**
 * Class AbstractFileHandler
 * @package RainbowPHP\File
 * @author Benjamin Perche <bperche9@gmail.com>
 */
abstract class AbstractFileHandler implements FileHandlerInterface
{
    protected $transactionLevel = 0;
    protected $buffers = [""];

    public function startTransaction()
    {
        $this->transactionLevel++;
        $this->buffers[$this->transactionLevel] = "";
    }

    public function commit()
    {
        if ($this->transactionLevel === 0) {
            throw new FileHandlerException("You must start a transaction before commit");
        }

        $this->buffers[$this->transactionLevel-1] .= $this->buffers[$this->transactionLevel];

        if ($this->transactionLevel === 1) {
            $this->write($this->buffers[0]);
        }

        $this->rollback();
    }

    public function rollback()
    {
        if ($this->transactionLevel === 0) {
            throw new FileHandlerException("You must start a transaction before rollback");
        }

        $this->transactionLevel--;
        unset($this->buffers[$this->transactionLevel+1]);
    }

    public function writeLine($message, $length = null)
    {
        if ($length !== null) {
            $length++;
        }

        $this->write($message."\n", $length);
    }

    public function append($message, $length = null)
    {
        $this->end();
        $this->write($message, $length);
    }

    public function write($message, $length = null)
    {
        if (null === $length) {
            $length = strlen($message);
        }

        if ($this->transactionLevel) {
            $this->buffers[$this->transactionLevel] .= substr($message, 0, $length);
        } else {
            $this->doWrite($message, $length);
        }
    }

    public function reset()
    {
        $this->seek(0);
    }

    abstract protected function doWrite($message, $length);
}
