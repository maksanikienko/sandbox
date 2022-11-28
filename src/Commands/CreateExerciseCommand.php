<?php


namespace Manikienko\Todo\Commands;

use Lazer\Classes\Database as Lazer;
use Lazer\Classes\Helpers\Config;
use Lazer\Classes\Helpers\Data;
use Manikienko\Todo\Database\ExerciseTable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateExerciseCommand extends Command
{

    public function configure()
    {
        parent::configure();
        $this->setName('exercise:create');

    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->text('Create new exercise');

        $exerciseDB = new ExerciseTable();

        $userData = [
            'name' => $io->ask("Exercise name:"),
            'difficulty_scale' => (int)$io->ask("Exercise rating:"),
            'type' => $io->choice("Exercise type:", ['Base', 'Isolate']),
            'level' => $io->choice("Exercise level:", ['Easy', 'Normal', 'Hard']),
            'weight_type' => $io->choice("Exercise Weight:", ['Barbell', 'Dumbell', 'Machine']),
        ];

        $exerciseDB->set($userData);
        $exerciseDB->insert();


        $io->table($exerciseDB->fields(), $exerciseDB->findAll(true));

        return Command::SUCCESS;
    }
}