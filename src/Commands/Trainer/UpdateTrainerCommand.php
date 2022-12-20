<?php

namespace Manikienko\Todo\Commands\Trainer;

use Manikienko\Todo\Model\Trainer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpdateTrainerCommand extends Command
{

    public function configure()
    {
        parent::configure();
        $this->setName('trainer:update');

        $this->addArgument('id', InputArgument::REQUIRED);
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->text('Update Trainer by ID');

        $id = (int)$input->getArgument('id');

        $trainer = new Trainer();

        $content = $trainer->find($id);

        $updatedFields = [
            'full_name' => $io->ask("Trainer name:"),
            'age' => (int)$io->ask("Age:"),
            'salary' =>  (int)$io->ask("Salary:",'$'),
            'family_status' => $io->choice("Status:",['Married','Single']),
            'email' => $io->ask("Email:"),
        ];

        $content->set($updatedFields);
        $content->save();

        $io->table($content->fields(), [$content->find($id)->asArray()]);

        $io->success('Trainer with id '.$id.' was updated');
     

        return Command::SUCCESS;
    }
}