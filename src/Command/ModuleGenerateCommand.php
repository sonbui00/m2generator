<?php

namespace Dylan\Generator\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ModuleGenerateCommand extends Command
{
    public function configure()
    {
        $this->setName('generator:module')->setDescription('Generate a basic module');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Hello world');
    }

}