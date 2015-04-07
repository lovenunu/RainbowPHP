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

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class RainbowGuessHashTypeCommand
 * @package RainbowPHP\Bridge\Symfony\Command
 * @author Benjamin Perche <bperche9@gmail.com>
 */
class RainbowGuessHashTypeCommand extends RainbowPHPCommand
{
    protected function configure()
    {
        parent::configure();

        $this
            ->setName("rainbow:guess")
            ->addArgument("hash", InputArgument::REQUIRED, "The hash you want to guess the type")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $hash = $input->getArgument("hash");
        $guessedTransformers = $this->rainbow->guessHashTransformer($hash);
        $guessedTransformersCount = count($guessedTransformers);

        if (0 === $guessedTransformersCount) {
            $output->writeln(sprintf("The hash '%s' seems to be not supported", $hash));
        } else {
            $formattedTransformers = "";

            foreach ($guessedTransformers as $alias => $transformer) {
                $formattedTransformers .= $transformer->getName();

                if ($alias !== $transformer->getName()) {
                    $formattedTransformers .= "(alias: ".$alias.")";
                }

                $formattedTransformers .= ',';
            }

            $output->writeln(sprintf(
                "%d type%s of hash has been found for the hash '%s': %s",
                $guessedTransformersCount,
                $guessedTransformersCount >= 2 ? "s" : "",
                $hash,
                substr($formattedTransformers, 0, -1)
            ));
        }
    }
}
