<?php


namespace Manikienko\Todo\Commands;

use Manikienko\Todo\Model\Gym;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateGymCommand extends Command
{

    public function configure()
    {
        parent::configure();
        $this->setName('gym:create');

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->text('Create new gym');

        $gymDB = new Gym();

        $userData = [
            'name' => $io->ask("Gym name:"),
            'location' => $io->ask("Location:"),
            'type' => $io->choice("Gym type:", ['Childrens', 'Adults']),
            'square' => (int)$io->ask("Square(sqaure metres):"),
            'segment_price' => $io->choice("Price:", ['Cheap', 'Expensive']),
        ];

        $gymDB->set($userData);
        $gymDB->insert();


        $io->table($gymDB->fields(), $gymDB->findAll(true));

        return Command::SUCCESS;
    }
}