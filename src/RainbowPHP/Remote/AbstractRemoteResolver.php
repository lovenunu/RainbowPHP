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

namespace RainbowPHP\Remote;
use RainbowPHP\File\MemoryFileHandler;


/**
 * Class AbstractRemoteResolver
 * @package RainbowPHP\Remote
 * @author Benjamin Perche <benjamin@thelia.net>
 */
abstract class AbstractRemoteResolver implements RemoteResolverInterface
{
    /**
     * @param string $value
     * @return \RainbowPHP\File\FileHandlerInterface Return false if the value can't be resolved
     */
    public function resolve($value)
    {
        $resolvedValue = $this->doResolve($value);

        if (false === $resolvedValue) {
            $resolvedValue = "";
        }

        $handler = new MemoryFileHandler();
        $handler->write($resolvedValue);

        return $handler;
    }

    /**
     * @param $value
     * @return false|string
     */
    abstract protected function doResolve($value);
}
