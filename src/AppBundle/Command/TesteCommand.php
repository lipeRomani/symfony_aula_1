<?php
/**
 * Created by PhpStorm.
 * User: romani
 * Date: 18/07/16
 * Time: 16:20
 */

namespace AppBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TesteCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName("yoda:event")
            ->setDescription("comando de teste")
            ->addOption('future',null,InputOption::VALUE_NONE,"Esta opção trará somente eventos com datas a partir da data atual.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $repo = $this->getContainer()->get('doctrine.orm.entity_manager')->getRepository('YodaEventBundle:Event');

        if($input->getOption('future')){
            $eventos = $repo->upcomingEvents();
        }else{
            $eventos = $repo->findAll();
        }

        foreach($eventos as $e){
            $output->writeln('<info>' . $e->getName() . '</info>' . " - " . '<comment>' . $e->getTime()->format('d/m/Y') . '</comment>');
        }
    }
}