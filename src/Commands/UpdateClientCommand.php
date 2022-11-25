<?php

namespace Manikienko\Todo\Commands;

use Manikienko\Todo\Database\ClientDatabase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpdateClientCommand extends Command
{

    public function configure()
    {
        parent::configure();
        $this->setName('');

        $this->addArgument('id', InputArgument::REQUIRED);
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->text('Update user by ID');

        $id = (int) $input->getArgument('id');

        $clientsDB = new ClientDatabase();

        $client = $clientsDB->find($id);

        $updatedFields = [
            'name' => $io->ask("User new name:"),
            'age' => (int)$io->ask("User new age:"),
            'status' => $io->choice("User new status:", ['active', 'inactive']),
        ];

        $client->set($updatedFields);
        $client->save();

        $io->table($clientsDB->fields(), $clientsDB->findAll(true));

        return Command::SUCCESS;
    }
}