<?php
/**
 * Created by PhpStorm.
 * User: pecalleja
 * Date: 07/12/2017
 * Time: 05:08 PM
 */

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class sumNumbersCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('AppBundle:sumnumbers')
            ->setDescription('Print the sum of all numbers that are multiple of 3, 5 and 7 from 1 to 1000');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $suma = 0;
        //$multiplos = [3, 5, 7];
        for($i = 1; $i<=1000; $i++)
        {
            if($i%3 == 0 and $i%5 == 0 and $i%7 ==0)
            {
                echo "Common multiple find: ".$i."\n";
                $suma = $suma + $i;
            }
            /*
            foreach ($multiplos as $item)
            {
                if($i%$item !== 0)
                {
                    continue 2;
                }
            }
            */
        }
        echo "the sum is: ".$suma;
    }

}