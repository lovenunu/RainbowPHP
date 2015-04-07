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

namespace RainbowPHP\Generator;

use RainbowPHP\DataProvider\DataProviderInterface;
use RainbowPHP\File\FileHandlerInterface;
use RainbowPHP\Formatter\FormatterInterface;
use RainbowPHP\Formatter\LineFormatter;
use RainbowPHP\Transformer\TransformerInterface;

/**
 * Class FileGenerator
 * @package RainbowPHP\Generator
 * @author Benjamin Perche <bperche9@gmail.com>
 */
class FileGenerator implements FileGeneratorInterface
{
    protected $fileHandler;
    protected $transformer;
    protected $dataProvider;
    protected $formatter;

    public function __construct(
        FileHandlerInterface $fileHandler,
        TransformerInterface $transformer,
        DataProviderInterface $dataProvider,
        FormatterInterface $formatter = null
    ) {
        $this->fileHandler = $fileHandler;
        $this->transformer = $transformer;
        $this->dataProvider = $dataProvider;
        $this->formatter = $formatter ?: new LineFormatter();
    }

    public function generateFile()
    {
        foreach ($this->dataProvider->generate() as $value) {
            if (null !== $value) {
                $this->fileHandler->writeLine($this->formatter->format($value, $this->transformer->transform($value)));
            }
        }
    }
}
