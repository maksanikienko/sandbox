<?php

namespace Manikienko\Todo\Commands\Client;

use Manikienko\Todo\Model\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateClientCommand extends Command
{

    public function configure()
    {
        parent::configure();
        $this->setName('client:create');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->text('Create new user');

        $client = new Client();

        $clientData = [
        'name'=> $io->ask("User name:"),
        'age' => (int)$io->ask("User age:"),
        'status' => $io->choice("User status:",[ 'active','inactive']),
        'email' => $io->ask("User email:"),
        ];
        
        $client->set($clientData);
        $client->insert();

        $io->table($client->fields(), [$client->asArray()]);

        return Command::SUCCESS;
    }
}
