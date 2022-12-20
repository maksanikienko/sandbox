<?php

namespace Manikienko\Todo\Commands\Client;

use Manikienko\Todo\Model\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DeleteClientCommand extends Command
{

    public function configure()
    {
        parent::configure();
        $this->setName('client:delete');

        $this->addArgument('id', InputArgument::REQUIRED);
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $confirm = $io->confirm('Do you want to delete a client?');
        if ($confirm == false) die();
        
        $id = (int) $input->getArgument('id');

        $client = new Client();

        $content = $client->find($id);
        
        $io->table($client->fields(), [$content->asArray()]);

        $io->success('Client with id '.$id.' was deleted');

        $content ->delete($id);

        return Command::SUCCESS;
    }
}