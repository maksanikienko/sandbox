<?php

namespace Manikienko\Todo\Commands;

use Manikienko\Todo\Model\Exercise;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ReadExerciseCommand extends Command
{

    public function configure()
    {
        parent::configure();
        $this->setName('exercise:read');

        $this->addArgument('id', InputArgument::REQUIRED);
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->text('Read exercise by ID');

        $id = (int) $input->getArgument('id');

        $query = Exercise::query();
        $io->horizontalTable($query->fields(), [$query->find($id)]);

        return Command::SUCCESS;
    }
}