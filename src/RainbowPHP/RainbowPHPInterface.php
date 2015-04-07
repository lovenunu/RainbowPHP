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

use RainbowPHP\File\FileHandlerInterface;
use RainbowPHP\Transformer\TransformerBagInterface;
use RainbowPHP\DataProvider\DataProviderInterface;

/**
 * Class RainbowPHP
 * @package RainbowPHP
 * @author Benjamin Perche <bperche9@gmail.com>
 */
interface RainbowPHPInterface extends TransformerBagInterface
{
    const LOOKUP_MODE_SIMPLE = 0;
    const LOOKUP_MODE_DEEP = 1;
    const LOOKUP_MODE_PARTIAL = 2;

    public function generateRainbowTable($fileHandler, DataProviderInterface $dataProvider, $transformer = null);

    /**
     * @param $hash
     * @return \RainbowPHP\Transformer\TransformerInterface[]
     *                                                        The keys of the return array must be the transformer alias
     */
    public function guessHashTransformer($hash);

    /**
     * @param FileHandlerInterface $rainbowTable
     * @param $hash
     * @param int                  $mode
     *
     * Use deep search mode if you want to find the results even there is conflicts
     * Use partial hash mode if you only have a partial hash, you should use deep search too to get all the possible results.
     */
    public function lookupHash(FileHandlerInterface $rainbowTable, $hash, $mode = self::LOOKUP_MODE_SIMPLE);
}
