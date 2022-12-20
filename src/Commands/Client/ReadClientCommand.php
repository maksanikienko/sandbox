<?php

namespace Manikienko\Todo\Commands\Client;

use Manikienko\Todo\Model\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ReadClientCommand extends Command
{

    public function configure()
    {
        parent::configure();
        $this->setName('client:read');

        $this->addArgument('id', InputArgument::REQUIRED);
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->text('Read client by ID');

        $id = (int) $input->getArgument('id');

        $query = Client::query();
        
        $io->horizontalTable($query->fields(), [$query->find($id)->asArray()]);

        return Command::SUCCESS;
    }
}