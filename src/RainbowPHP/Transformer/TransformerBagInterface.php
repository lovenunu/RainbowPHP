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

namespace RainbowPHP\Transformer;

/**
 * Interface TransformerBagInterface
 * @package RainbowPHP\Transformer
 * @author Benjamin Perche <bperche9@gmail.com>
 */
interface TransformerBagInterface
{
    /**
     * @param  TransformerInterface $transformer
     * @param  null                 $name
     * @return $this
     */
    public function addTransformer(TransformerInterface $transformer, $name = null);

    public function hasTransformer($name);

    public function deleteTransformer($name);

    public function resolveTransformer($transformer);

    public function listTransformerNames();

    /**
     * @return TransformerInterface[]
     */
    public function allTransformers();
}
