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

namespace RainbowPHP\Tests;

use org\bovigo\vfs\vfsStream;

/**
 * Class RainbowPHPVfsTestCase
 * @package RainbowPHP\Tests
 * @author Benjamin Perche <bperche9@gmail.com>
 */
class RainbowPHPVfsTestCase extends \PHPUnit_Framework_TestCase
{
    /** @var  \org\bovigo\vfs\vfsStreamDirectory */
    protected $vfs;

    /** @var  \org\bovigo\vfs\vfsStreamFile */
    protected $file;

    /** @var  string */
    protected $fileUrl;

    protected function setUp()
    {
        $this->vfs = vfsStream::setup("rainbowphp", 0777);
        $this->file = vfsStream::newFile("file1", 0777)->at($this->vfs);
        $this->fileUrl = $this->getVfsRootDir()."/file1";
    }

    protected function getVfsRootDir()
    {
        return $this->vfs->url();
    }
}
