<?php
/*************************************************************************************/
/* This file is part of the Thelia package.                                          */
/*                                                                                   */
/* Copyright (c) OpenStudio                                                          */
/* email : dev@thelia.net                                                            */
/* web : http://www.thelia.net                                                       */
/*                                                                                   */
/* For the full copyright and license information, please view the LICENSE.txt       */
/* file that was distributed with this source code.                                  */
/*************************************************************************************/

namespace RainbowPHP\Bridge\Symfony\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * Class RainbowBase64DecodeCommand
 * @package RainbowPHP\Bridge\Symfony\Command
 * @author Benjamin Perche <benjamin@thelia.net>
 */
class RainbowBase64DecodeCommand extends RainbowPHPCommand
{
    protected function configure()
    {
        parent::configure();

        $this
            ->setName("rainbow:base64:decode")
            ->addArgument("value", InputArgument::REQUIRED, "The base64 value to decode")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $transformer = $this->rainbow->getTransformer("base64");
        $value = $input->getArgument("value");

        if (!$transformer->canValueBeReversed($value)) {
            throw new \InvalidArgumentException(sprintf("The value '%s' is not a valid base64", $value));
        }

        $output->writeln($transformer->reverseTransformation($value));
    }
}
