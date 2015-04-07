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

use RainbowPHP\Exception\RainbowPHPException;

/**
 * Trait TransformerBagTrait
 * @package RainbowPHP\Transformer
 * @author Benjamin Perche <bperche9@gmail.com>
 */
trait TransformerBagTrait
{
    /** @var TransformerInterface[] */
    protected $transformerCollection;

    public function addTransformer(TransformerInterface $transformer, $name = null)
    {
        if (null !== $name) {
            $this->transformerCollection[$name] = $transformer;
        } else {
            $this->transformerCollection[$transformer->getName()] = $transformer;
        }

        return $this;
    }

    public function hasTransformer($name)
    {
        return isset($this->transformerCollection[$name]);
    }

    public function deleteTransformer($name)
    {
        if (!$this->hasTransformer($name)) {
            throw new \OutOfBoundsException(sprintf("The transformer '%s' doesn't exist", $name));
        }

        unset($this->transformerCollection[$name]);
    }

    public function resolveTransformer($transformer)
    {
        if (!$transformer instanceof TransformerInterface) {
            if (null === $transformer) {
                reset($this->transformerCollection);
                $transformer = current($this->transformerCollection);

                if (false === $transformer) {
                    throw new RainbowPHPException("The is currently no available transformer");
                }
            } elseif (is_array($transformer)) {
                $transformerInstance = new ChainedTransformer();

                foreach ($transformer as $key => $transformerChild) {
                    $transformerInstance->addTransformer($this->resolveTransformer($transformerChild), $key);
                }

                $transformer = $transformerInstance;
            } else {
                if (!$this->hasTransformer($transformer)) {
                    throw new RainbowPHPException(sprintf("The transformer '%s' doesn't exist", $transformer));
                }

                $transformer = $this->transformerCollection[$transformer];
            }
        }

        return $transformer;
    }

    public function listTransformerNames()
    {
        return array_keys($this->transformerCollection);
    }

    public function allTransformers()
    {
        return $this->transformerCollection;
    }
}
