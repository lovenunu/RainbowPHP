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

namespace RainbowPHP\Bridge\Symfony\Command;

use RainbowPHP\File\FileHandler;
use RainbowPHP\File\FileHandlerInterface;
use RainbowPHP\RainbowPHPInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use RainbowPHP\Bridge\Symfony\Command\Exception\MissingOptionException;

/**
 * Class RainbowLookupHashCommand
 * @package RainbowPHP\Bridge\Symfony\Command
 * @author Benjamin Perche <bperche9@gmail.com>
 */
class RainbowLookupHashCommand extends RainbowPHPCommand
{
    protected function configure()
    {
        parent::configure();

        $this
            ->setName("rainbow:lookup")
            ->addArgument("hash", InputArgument::REQUIRED, "The hash you want to guess the type")
            ->addOption("rainbow-table", "r", InputOption::VALUE_REQUIRED, "The rainbow table to use")
            ->addOption("deep-search", "d", InputOption::VALUE_NONE, "Deep search in the rainbow table")
            ->addOption("partial", "p", InputOption::VALUE_NONE, "The given hash is partial")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $missingOption = [];
        $optionScopeCount = 1;

        if (null === $rainbowTablePath = $input->getOption("rainbow-table")) {
            $missingOption[] = "rainbow-table";
        }

        if ($optionScopeCount === count($missingOption)) {
            throw MissingOptionException::create($missingOption);
        }

        $rainbowTable = new FileHandler($rainbowTablePath, FileHandlerInterface::MODE_READ_ONLY);

        $mode = RainbowPHPInterface::LOOKUP_MODE_SIMPLE;

        if ($input->getOption("partial")) {
            $mode |= RainbowPHPInterface::LOOKUP_MODE_PARTIAL;
        }

        if ($input->getOption("deep-search")) {
            $mode |= RainbowPHPInterface::LOOKUP_MODE_DEEP;
        }

        $hash = $input->getArgument("hash");

        $foundHashes = $this->rainbow->lookupHash($rainbowTable, $hash, $mode);

        if (empty($foundHashes)) {
            $output->writeln(sprintf("No value found for the hash '%s'", $hash));
        } else {
            $tableHelper = new Table($output);
            $tableHelper->setHeaders(["Hash", "Value"]);

            foreach ($foundHashes as $value => $foundHash) {
                $tableHelper->addRow([$foundHash, $value]);
            }

            $tableHelper->render();
        }
    }
}
