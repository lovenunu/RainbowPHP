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


/**
 * Interface RemoteResolverInterface
 * @package RainbowPHP\Remote
 * @author Benjamin Perche <benjamin@thelia.net>
 */
interface RemoteResolverInterface
{
    /**
     * @param string $value
     * @return \RainbowPHP\File\FileHandlerInterface Return false if the value can't be resolved
     */
    public function resolve($value);

    /**
     * @return string The resolver name
     */
    public function getName();
}
