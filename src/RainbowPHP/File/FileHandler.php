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
class FileHandler extends AbstractFileHandler
{
    private $resource;
    private $filePath;

    public function __construct($path, $mode = self::MODE_APPEND_AND_READ)
    {
        $this->filePath = $path;
        $this->open($path, $mode);
    }

    public function open($path, $mode = self::MODE_APPEND_AND_READ)
    {
        $this->resource = fopen($path, $mode);
    }

    public function seek($offset, $whence = SEEK_SET)
    {
        fseek($this->resource, $offset, $whence);
    }

    public function end()
    {
        feof($this->resource);
    }

    public function readLine($length = null)
    {
        if (null === $length) {
            $line = fgets($this->resource);
        } else {
            $line = fgets($this->resource, $length);
        }

        if (false === $line) {
            return "";
        }

        return rtrim($line, "\n");
    }

    public function read($length = null)
    {
        if (null === $length) {
            $length = filesize($this->filePath);
        }

        return fread($this->resource, $length);
    }

    /**
     * @return mixed
     */
    public function getResource()
    {
        return $this->resource;
    }

    public function getFileInfo()
    {
        return new \SplFileInfo($this->filePath);
    }

    protected function doWrite($message, $length)
    {
        fwrite($this->resource, $message, $length);
    }
}
