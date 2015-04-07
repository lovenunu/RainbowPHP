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

use RainbowPHP\DataProvider\FileDataProvider;
use RainbowPHP\DataProvider\IncrementalDataProvider;
use RainbowPHP\File\FileHandler;
use RainbowPHP\File\FileHandlerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class RainbowGenerateCommand
 * @package RainbowPHP\Bridge\Symfony\Command
 * @author Benjamin Perche <bperche9@gmail.com>
 */
class RainbowGenerateCommand extends RainbowPHPCommand
{
    const DEFAULT_MIN_LENGTH = 1;
    const DEFAULT_MAX_LENGTH = 8;

    protected function configure()
    {
        parent::configure();

        $this->setName("rainbow:generate")
            ->addArgument(
                "transformers",
                InputArgument::REQUIRED,
                "The transformer(s) to use. You can chain them with commas. For instance: md5,md5 will result in a md5 of a md5. ".
                "Available transformers: ".implode(",", $this->rainbow->listTransformerNames())
            )
            ->addOption("max-length", "e", InputOption::VALUE_REQUIRED, "The max length of the data to generate")
            ->addOption(
                "char-list",
                "c",
                InputOption::VALUE_REQUIRED,
                "The char-list format, ::alpha:: stands for alpha, ::ALPHA:: for uppercase alpha; ::Alpha:: for both and ::numeric for numeric. Then you can add the special chars you want",
                "::Alpha::::numeric::"
            )
            ->addOption("dictionary", "d", InputOption::VALUE_REQUIRED, "The dictionnary file to use. Words must be separated by line return")
            ->addOption("min-length", "m", InputOption::VALUE_REQUIRED, "The start minimum length for the strings to generate")
            ->addOption("filepath", "f", InputOption::VALUE_REQUIRED, "The path where the rainbow table will be generated", "php://stdout")
            //->addOption("file", "f", InputOption::VALUE_REQUIRED, "The source file for lookup")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $charList = $input->getOption("char-list");
        $charList = str_replace("::Alpha::", "::alpha::::ALPHA::", $charList);
        $charList = str_replace("::alpha::", IncrementalDataProvider::CHAR_LIST_ALPHA_LOWER, $charList);
        $charList = str_replace("::ALPHA::", IncrementalDataProvider::CHAR_LIST_ALPHA_UPPER, $charList);
        $charList = str_replace("::numeric::", IncrementalDataProvider::CHAR_LIST_NUMBER, $charList);

        $minLength = (int) (null !== $input->getOption("min-length") ? $input->getOption("min-length") : static::DEFAULT_MIN_LENGTH);
        $maxLength = (int) (null !== $input->getOption("max-length") ? $input->getOption("max-length") : static::DEFAULT_MAX_LENGTH);
        $transformers = $input->getArgument("transformers");

        if (null !== $input->getOption("dictionary")) {
            $dataProvider = new FileDataProvider(new FileHandler($input->getOption("dictionary")));
        } else {
            $dataProvider = new IncrementalDataProvider($minLength, $maxLength, [$charList]);
        }

        $file = $input->hasOption("filepath") ? $input->getOption("filepath") : "php://stdout";

        $fileHandler = new FileHandler(
            $file,
            $input->hasOption("filepath") ?
                FileHandlerInterface::MODE_APPEND_AND_READ :
                FileHandlerInterface::MODE_ERASE_AND_WRITE_ONLY
        );

        $this->rainbow->generateRainbowTable($fileHandler, $dataProvider, array_map("trim", explode(",", $transformers)));
    }
}
