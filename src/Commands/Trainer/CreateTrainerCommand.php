<?php


namespace Manikienko\Todo\Commands\Trainer;

use Manikienko\Todo\Model\Trainer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateTrainerCommand extends Command
{

    public function configure()
    {
        parent::configure();
        $this->setName('trainer:create');

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->text('Create new trainer');

        $trainerDB = new Trainer();

        $userData = [
            'full_name' => $io->ask("Trainer name:"),
            'age' => (int)$io->ask("Age:"),
            'salary' =>  (int)$io->ask("Salary:",'$'),
            'family_status' => $io->choice("Status:",['Married','Single']),
            'email' => $io->ask("Email:"),
        ];

        $trainerDB->set($userData);
        $trainerDB->insert();


        $io->table($trainerDB->fields(), $trainerDB->findAll(true));

        return Command::SUCCESS;
    }
}