<?php

namespace Manikienko\Todo\Commands;

use Manikienko\Todo\Database\ExerciseTable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DeleteExerciseCommand extends Command
{

    public function configure()
    {
        parent::configure();
        $this->setName('exercise:delete');

        $this->addArgument('id', InputArgument::REQUIRED);
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->text('Delete exercise by ID');

        $id = (int) $input->getArgument('id');

        $exerciseDB = new ExerciseTable();

        $exercise = $exerciseDB->find($id);

        $exercise->delete($id);

        $io->table($exerciseDB->fields(), $exerciseDB->findAll(true));

        return Command::SUCCESS;
    }
}