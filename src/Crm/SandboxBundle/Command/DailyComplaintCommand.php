<?php

namespace Crm\SandboxBundle\Command;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DailyComplaintCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('daily:complaint')
            ->setDescription('Sends Daily Complaint Emails to everyone')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $message = $this->getContainer()->get('crm.mailingBundle.mailingManager')->sendDailyTasks();
        $output->writeln($message);
    }
}