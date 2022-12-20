<?php


namespace Manikienko\Todo\Commands\Exercise;

use Manikienko\Todo\Model\Exercise;
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

        $exercise = new Exercise();

        $userData = [
            'name' => $io->ask("Exercise name:"),
            'difficulty_scale' => (int)$io->ask("Exercise rating:"),
            'type' => $io->choice("Exercise type:", ['Base', 'Isolate']),
            'level' => $io->choice("Exercise level:", ['Easy', 'Normal', 'Hard']),
            'weight_type' => $io->choice("Exercise Weight:", ['Barbell', 'Dumbell', 'Machine']),
        ];

        $exercise->set($userData);
        $exercise->insert();


        $io->table($exercise->fields(), $exercise->findAll(true));

        $io->success('New exercise was created');

        return Command::SUCCESS;
    }
}