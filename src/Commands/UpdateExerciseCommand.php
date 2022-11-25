<?php

namespace Manikienko\Todo\Commands;

use Manikienko\Todo\Database\ExerciseDatabase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpdateExerciseCommand extends Command
{

    public function configure()
    {
        parent::configure();
        $this->setName('exercise:update');

        $this->addArgument('id', InputArgument::REQUIRED);
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->text('Update exercise by ID');

        $id = (int) $input->getArgument('id');

        $exerciseDB = new ExerciseDatabase();

        $exercise = $exerciseDB->find($id);

        $updatedFields = [
            /* fixme укажи только те поля которые ты хочешь обновить */
            'name' => $io->ask("User new name:"),
            'age' => (int)$io->ask("User new age:"),
            'status' => $io->choice("User new status:", ['active', 'inactive']),
        ];

        $exercise->set($updatedFields);
        $exercise->save();

        $io->table($exerciseDB->fields(), $exerciseDB->findAll(true));

        return Command::SUCCESS;
    }
}