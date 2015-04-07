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

namespace RainbowPHP\DataProvider;

use RainbowPHP\File\FileHandlerInterface;

/**
 * Class FileDataProvider
 * @package RainbowPHP\DataProvider
 * @author Benjamin Perche <bperche9@gmail.com>
 */
class FileDataProvider implements  DataProviderInterface
{
    const DEFAULT_DEMILITER = "\n";

    private $fileHandler;
    private $delimiters;
    private $delimitersLength;
    private $minDelimiterLength;

    public function __construct(FileHandlerInterface $fileHandler, $delimiters = array(self::DEFAULT_DEMILITER))
    {
        $this->fileHandler = $fileHandler;
        $this->delimiters = $delimiters;
        $this->delimitersLength = array_map("strlen", $delimiters);
        $this->minDelimiterLength = min($this->delimitersLength);
    }

    /**
     * @return mixed[]|\Iterator|\Generator Then current generated value
     *
     * It must return null when generation is finish
     */
    public function generate()
    {
        generate_start:
        $buffer = "";
        $currentLength = 0;
        $success = false;

        do {
            $extractedData = (string) $this->fileHandler->read($this->minDelimiterLength);
            $currentLength += strlen($extractedData);

            if ("" === $extractedData) {
                if ("" !== $buffer) {
                    yield $buffer;
                }

                return;
            }

            $buffer .= $extractedData;

            foreach ($this->delimiters as $key => $delimiter) {
                if ($currentLength - $this->delimitersLength[$key] === strpos($buffer, $delimiter)) {
                    yield substr($buffer, 0, -$this->delimitersLength[$key]);
                    $success = true;

                    break;
                }
            }
        } while (!$success);

        goto generate_start; # because while(true)
    }
}
