<?php

namespace Manikienko\Todo\Commands\Trainer;

use Manikienko\Todo\Model\Trainer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ReadTrainerCommand extends Command
{

    public function configure()
    {
        parent::configure();
        $this->setName('trainer:read');

        $this->addArgument('id', InputArgument::REQUIRED);
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->text('Read Trainer by ID');

        $id = (int) $input->getArgument('id');

        $query = Trainer::query();
        
        $io->horizontalTable($query->fields(), [$query->find($id)->asArray()]);

        return Command::SUCCESS;
    }
}