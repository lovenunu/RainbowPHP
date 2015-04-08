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
 * Class RainbowUrlEncodeCommand
 * @package RainbowPHP\Bridge\Symfony\Command
 * @author Benjamin Perche <benjamin@thelia.net>
 */
class RainbowUrlEncodeCommand extends RainbowPHPCommand
{
    protected function configure()
    {
        parent::configure();

        $this
            ->setName("rainbow:url:encode")
            ->addArgument("value", InputArgument::REQUIRED, "The value to urlencode")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $output->writeln($this->rainbow->getTransformer("urlencode")->transform($input->getArgument("value")));
    }
}
