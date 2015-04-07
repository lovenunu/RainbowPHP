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

use RainbowPHP\RainbowPHPInterface;
use RainbowPHP\Transformer\TransformerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class RainbowPHPCommand
 * @package RainbowPHP\Bridge\Symfony\Command
 * @author Benjamin Perche <bperche9@gmail.com>
 */
class RainbowPHPCommand extends Command
{
    protected $rainbow;

    public function __construct(RainbowPHPInterface $rainbow)
    {
        $this->rainbow = $rainbow;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->addOption("load-file", "l", InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, "Files to load (PHP classes, functions ...)")
            ->addOption("custom-transformer", "t", InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, "Class names to add as transformer")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($input->getOption("load-file") as $fileToLoad) {
            require $fileToLoad;
        }

        foreach ($input->getOption("custom-transformer") as $customTransformer) {
            $reflection = new \ReflectionClass($customTransformer);

            if (!$reflection->implementsInterface(TransformerInterface::class)) {
                throw new \InvalidArgumentException(sprintf("The class '%s' must implement %s",
                    $customTransformer,
                    TransformerInterface::class
                ));
            }

            $this->rainbow->addTransformer($reflection->newInstance());
        }
    }
}
