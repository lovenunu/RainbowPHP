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
     * @param  TransformerInterface|ReverseTransformerInterface $transformer
     * @param  null                 $name
     * @return $this
     */
    public function addTransformer($transformer, $name = null);

    public function addTransformerOnly(TransformerInterface $transformer, $name = null);

    public function addReverseTransformerOnly(ReverseTransformerInterface $transformer, $name = null);

    /**
     * @param $name
     * @return bool
     */
    public function hasTransformer($name);

    public function hasTransformerOnly($name);

    public function hasReverseTransformerOnly($name);

    public function deleteTransformer($name);

    public function deleteTransformerOnly($name);

    public function deleteReverseTransformerOnly($name);

    public function resolveTransformer($transformer);

    public function listTransformerNames();

    /**
     * @param $name
     * @return TransformerInterface|TransformerAndReverserInterface
     */
    public function getTransformer($name);

    public function getTransformerOnly($name);

    public function getReverseTransformerOnly($name);

    /**
     * @return TransformerInterface[]
     */
    public function allTransformers();
}
