<?php
/*************************************************************************************/
/* This file is part of the Thelia package.                                          */
/*                                                                                   */
/* Copyright (c) OpenStudio                                                          */
/* email : dev@thelia.net                                                            */
/* web : http://www.thelia.net                                                       */
/*                                                                                   */
/* For the full copyright and license information, please view the LICENSE.txt       */
/* file that was distributed with this source code.                                  */
/*************************************************************************************/

namespace RainbowPHP\Tests;

use org\bovigo\vfs\vfsStream;

/**
 * Class RainbowPHPVfsTestCase
 * @package RainbowPHP\Tests
 * @author Benjamin Perche <benjamin@thelia.net>
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
        $this->file = vfsStream::newFile("file1", 0777)->at($this->vfs)->withContent("foo,bar\nbar,baz\nfoo,baz\n");
        $this->fileUrl = $this->getVfsRootDir()."/file1";
    }

    protected function getVfsRootDir()
    {
        return $this->vfs->url();
    }
}
