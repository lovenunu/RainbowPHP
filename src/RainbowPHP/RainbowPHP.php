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

use RainbowPHP\DataProvider\DataProviderInterface;
use RainbowPHP\File\FileHandlerInterface;
use RainbowPHP\Formatter\FormatterInterface;
use RainbowPHP\Formatter\LineFormatter;
use RainbowPHP\Generator\FileGenerator;
use RainbowPHP\File\FileHandler;
use RainbowPHP\Transformer\TransformerBagTrait;

/**
 * Class RainbowPHP
 * @package RainbowPHP
 * @author Benjamin Perche <bperche9@gmail.com>
 */
class RainbowPHP implements RainbowPHPInterface
{
    use TransformerBagTrait;

    protected $formatter;

    public function __construct(FormatterInterface $formatter = null)
    {
        $this->formatter = $formatter ?: new LineFormatter();
    }

    public function generateRainbowTable($fileHandler, DataProviderInterface $dataProvider, $transformer = null)
    {
        if (!$fileHandler instanceof FileHandlerInterface) {
            $fileHandler = new FileHandler($fileHandler);
        }

        $fileGenerator = new FileGenerator(
            $fileHandler,
            $this->resolveTransformer($transformer),
            $dataProvider,
            $this->formatter
        );

        $fileGenerator->generateFile();
    }

    public function guessHashTransformer($hash)
    {
        $possibleTransformers = [];

        foreach ($this->transformerCollection as $key => $transformer) {
            if ($transformer->canHaveBeenHashedByMe($hash)) {
                $possibleTransformers[$key] = $transformer;
            }
        }

        return $possibleTransformers;
    }

    /**
     * @param FileHandlerInterface $rainbowTable
     * @param $hash
     * @param int                  $mode
     * @return array               The found values
     *
     * Use deep search mode if you want to find the results even there is conflicts
     * Use partial hash mode if you only have a partial hash, you should use deep search too to get all the possible results.
     */
    public function lookupHash(FileHandlerInterface $rainbowTable, $hash, $mode = self::LOOKUP_MODE_SIMPLE)
    {
        $deep = (bool) ($mode & static::LOOKUP_MODE_DEEP);
        $partial = (bool) ($mode & static::LOOKUP_MODE_PARTIAL);

        $returnResult = [];

        while ("" !== $line = $rainbowTable->readLine()) {
            $data = $this->formatter->unformat($line);

            if ($hash === key($data) || (true === $partial && false !== strpos(key($data), $hash))) {
                $returnResult += $data;

                if (false === $deep) {
                    return $returnResult;
                }
            }
        }

        return $returnResult;
    }
}
