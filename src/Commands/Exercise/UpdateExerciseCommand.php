<?php

namespace Manikienko\Todo\Commands\Exercise;

use Manikienko\Todo\Model\Exercise;
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

        $id = (int)$input->getArgument('id');

        $exercise = new Exercise();

        $content = $exercise->find($id);

        $updatedFields = [
            'name' => $io->ask("Exercise name:"),
            'difficulty_scale' => (int)$io->ask("Exercise rating:"),
            'type' => $io->choice("Exercise type:", ['Base', 'Isolate']),
            'level' => $io->choice("Exercise level:", ['Easy', 'Normal', 'Hard']),
            'weight_type' => $io->choice("Exercise Weight:", ['Barbell', 'Dumbell', 'Machine']),
        ];

        $content->set($updatedFields);
        $content->save();

        $io->table($exercise->fields(), [$content->find($id)->asArray()]);

        $io->success('Exercise with id '.$id.' was updated');

        return Command::SUCCESS;
    }
}