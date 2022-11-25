<?php

namespace Manikienko\Todo\Commands;

use Manikienko\Todo\Database\ClientDatabase;
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

        $clientsDB = new ClientDatabase();

        $userData = [
            'name' => $io->ask("User name:"),
            'age' => (int)$io->ask("User age:"),
            'status' => $io->choice("User status:", ['active', 'inactive']),
        ];

        $clientsDB->set($userData);
        $clientsDB->insert();


        $io->table($clientsDB->fields(), $clientsDB->findAll(true));

        return Command::SUCCESS;
    }
}
