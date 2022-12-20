<?php

namespace Manikienko\Todo\Commands\Trainer;

use Manikienko\Todo\Model\Trainer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DeleteTrainerCommand extends Command
{

    public function configure()
    {
        parent::configure();
        $this->setName('trainer:delete');

        $this->addArgument('id', InputArgument::REQUIRED);
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $confirm = $io->confirm('Do you want to delete a trainer?');
        if ($confirm == false) die();
        
        $id = (int) $input->getArgument('id');

        $trainer = new Trainer();

        $content = $trainer->find($id);
        
        $io->table($trainer->fields(), [$content->asArray()]);

        $io->success('Trainer with id '.$id.' was deleted');

        $content ->delete($id);

        return Command::SUCCESS;
    }
}