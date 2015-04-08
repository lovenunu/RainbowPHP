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

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;


/**
 * Class RainbowBase64EncodeCommand
 * @package RainbowPHP\Bridge\Symfony\Command
 * @author Benjamin Perche <benjamin@thelia.net>
 */
class RainbowBase64EncodeCommand extends RainbowPHPCommand
{
    protected function configure()
    {
        parent::configure();

        $this
            ->setName("rainbow:base64:encode")
            ->addArgument("value", InputArgument::REQUIRED, "The value to encode in base64")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $output->writeln($this->rainbow->getTransformer("base64")->transform($input->getArgument("value")));
    }
}
