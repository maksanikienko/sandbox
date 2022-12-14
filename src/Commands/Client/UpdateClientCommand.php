<?php

namespace Manikienko\Todo\Commands\Client;

use Manikienko\Todo\Model\Client;
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
        $this->setName('client:update');

        $this->addArgument('id', InputArgument::REQUIRED);
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->text('Update user by ID');

        $id = (int)$input->getArgument('id');

        $client = new Client();

        $content = $client->find($id);

        $updatedFields = [
            'name' => $io->ask("User new name:"),
            'age' => (int)$io->ask("User new age:"),
            'status' => $io->choice("User new status:", ['active', 'inactive']),
        ];

        $content->set($updatedFields);
        $content->save();

        $io->table($content->fields(), [$content->find($id)->asArray()]);

        $io->success('Client with id '.$id.' was updated');
     

        return Command::SUCCESS;
    }
}