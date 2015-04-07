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

use RainbowPHP\DataProvider\Exception\InvalidArgumentException;

/**
 * Class IncrementalDataProvider
 * @package RainbowPHP\DataProvider
 * @author Benjamin Perche <bperche9@gmail.com>
 */
class IncrementalDataProvider implements DataProviderInterface
{
    const CHAR_LIST_ALPHA_LOWER = "abcdefghijklmnopqrstuvwxyz";
    const CHAR_LIST_ALPHA_UPPER = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    const CHAR_LIST_NUMBER      = "0123456789";

    private $minLength;
    private $maxLength;
    private $charList;
    private $charListLength;
    private $charListLastChar;
    private $currentValue;
    private $nextCharListTable;

    /**
     * @param int $minLength
     * @param int $maxLength
     * @param string[] $charList
     */
    public function __construct($minLength, $maxLength, array $charList = array(self::CHAR_LIST_ALPHA_LOWER))
    {
        if (!is_numeric($minLength) || $minLength < 1) {
            throw InvalidArgumentException::create("minLength", $minLength, "It must be greater than 0");
        }

        $this->minLength = (int) $minLength;

        if (!is_numeric($maxLength) || $maxLength < $minLength) {
            throw InvalidArgumentException::create("maxLength", $maxLength, "It must be grater than minLength");
        }

        $this->maxLength = (int) $maxLength;

        $this->charList = implode("", array_unique(str_split(implode("", $charList))));
        $this->charListLength = strlen($this->charList);

        if (0 === $this->charListLength) {
            throw InvalidArgumentException::create("charList", var_export($charList));
        }

        $charListLimit = $this->charListLength-1;

        for ($i = 0; $i < $charListLimit; $i++) {
            $this->nextCharListTable[$this->charList[$i]] = $this->charList[$i+1];
        }

        $this->charListLastChar = $this->charList[$charListLimit];
        $this->currentValue = str_repeat($this->charList[0], $this->minLength);
    }

    /**
     * @return mixed[]|\Iterator|\Generator Then current generated value
     *
     * It must return null when generation is finish
     */
    public function generate()
    {
        while (strlen($this->currentValue) <= $this->maxLength) {
            yield $this->currentValue;

            $this->persistIncrement();
        }

        yield null;
    }

    public function persistIncrement()
    {
        return $this->currentValue = $this->increment();
    }

    public function increment($charPos = -1)
    {
        $valLength = strlen($this->currentValue);

        if ($this->charListLastChar !== $currentChar = substr($this->currentValue, $charPos, 1)) {
            // Replace current by the next one, and reset all the following chars
            $id = substr_replace($this->currentValue, $this->nextCharListTable[$currentChar], $charPos, 1);

            return substr($id, 0, $valLength+$charPos+1).str_repeat($this->charList[0], -$charPos-1);
        } elseif ($charPos === -$valLength) {
            return str_repeat($this->charList[0], $valLength+1);
        }

        return $this->increment($charPos-1);
    }
}
