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

namespace RainbowPHP;

use RainbowPHP\Transformer\Md5Transformer;
use RainbowPHP\Transformer\MysqlPasswordTransformer;
use RainbowPHP\Transformer\Sha1Transformer;

/**
 * Class RainbowPHPFactory
 * @package RainbowPHP
 * @author Benjamin Perche <bperche9@gmail.com>
 */
class RainbowPHPFactory
{
    /** @var RainbowPHPInterface  */
    protected $instance;

    public function __construct(RainbowPHPInterface $instance = null)
    {
        $this->instance = $instance ?: new RainbowPHP();
    }

    public function registerCoreTransformer()
    {
        $this->instance
            ->addTransformer(new Md5Transformer())
            ->addTransformer(new Sha1Transformer())
            ->addTransformer(new MysqlPasswordTransformer())
        ;
    }

    public function create()
    {
        $this->registerCoreTransformer();

        return $this->instance;
    }
}
