<?php

namespace Manikienko\Todo\Commands\Gym;

use Manikienko\Todo\Model\Gym;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DeleteGymCommand extends Command
{

    public function configure()
    {
        parent::configure();
        $this->setName('gym:delete');

        $this->addArgument('id', InputArgument::REQUIRED);
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $confirm = $io->confirm('Do you want to delete a gym?');
        if ($confirm == false) die();
        
        $id = (int) $input->getArgument('id');

        $gym = new Gym();

        $content = $gym->find($id);
        
        $io->table($gym->fields(), [$gym->asArray()]);

        $io->success('Gym with id '.$id.' was deleted');

        $content ->delete($id);

        return Command::SUCCESS;
    }
}