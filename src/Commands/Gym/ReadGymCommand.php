<?php

namespace Manikienko\Todo\Commands\Gym;

use Manikienko\Todo\Model\Gym;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ReadGymCommand extends Command
{

    public function configure()
    {
        parent::configure();
        $this->setName('gym:read');

        $this->addArgument('id', InputArgument::REQUIRED);
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->text('Read gym by ID');

        $id = (int) $input->getArgument('id');

        $query = Gym::query();
        
        $io->horizontalTable($query->fields(), [$query->find($id)->asArray()]);

        return Command::SUCCESS;
    }
}