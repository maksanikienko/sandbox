<?php

namespace Manikienko\Todo\Commands\Exercise;

use Manikienko\Todo\Model\Exercise;
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

        $confirm = $io->confirm('Do you want to delete a exercise?');
        if ($confirm == false) die();

        $id = (int) $input->getArgument('id');

        $exercise = new Exercise();

        $content = $exercise->find($id);

        $io->table($exercise->fields(), [$content->asArray()]);

        $io->success('Exercise with id '.$id.' was deleted');

        $content->delete($id);

        

        return Command::SUCCESS;
    }
}