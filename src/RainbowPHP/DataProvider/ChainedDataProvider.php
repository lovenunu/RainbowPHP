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


/**
 * Class ChainedDataProvider
 * @package RainbowPHP\DataProvider
 * @author Benjamin Perche <bperche9@gmail.com>
 *
 * @deprecated Do not use, not finished yet
 * @todo
 */
class ChainedDataProvider implements DataProviderInterface
{
    protected $dataProviders = array();

    public function addDataProvider(DataProviderInterface $dataProvider, $name = null, $priority = 0)
    {
        $entry = [$priority, $dataProvider];

        if (null !== $name) {
            $this->dataProviders[$name] = $entry;
        } else {
            $this->dataProviders[] = $entry;
        }
    }

    public function hasDataProvider($name)
    {
        return isset($this->dataProviders[$name]);
    }

    public function deleteDataProvider($name)
    {
        if (!$this->hasDataProvider($name)) {
            throw new \OutOfBoundsException(sprintf("The data provider '%s' doesn't exist", $name));
        }

        unset($this->dataProviders[$name]);
    }

    /**
     * @return mixed[]|\Iterator|\Generator Then current generated value
     *
     * It must return null when generation is finish
     */
    public function generate()
    {
        $providerLevel = count($this->dataProviders);

        if (0 === $providerLevel) {
            return null;
        }

        $this->sortDataProviders();
        reset($this->dataProviders);

        $data = [];
        while (null !== $providerEntry = current($this->dataProviders)) {
            /** @var DataProviderInterface $dataProvider */
            $dataProvider = $providerEntry[1];
            $data[] =  $dataProvider->generate();
            next($this->dataProviders);
        }

        yield implode($data);

        // @todo finish looping

        $providerLevel--;
        while (null !== $entry = $dataProvider->generate()) {
            $data[$providerLevel] = $entry;

            yield implode($data);
        }
    }

    protected function sortDataProviders()
    {
        usort($this->dataProviders, function($a, $b) {
            if ($a[0] == $b[0]) {
                return 0;
            }

            return $a < $b ? 1 : -1;
        });
    }
}
