<?php


namespace Manikienko\Todo\Commands\Workout;

use Manikienko\Todo\Model\Client;
use Manikienko\Todo\Model\Workout;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateWorkoutCommand extends Command
{

    public function configure()
    {
        parent::configure();
        $this->setName('workout:create');

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->text('Create new workout');

        $nameToSearch = $io->ask('Specify client name:');
            
        $client = Client::query()->where('name', '=' , $nameToSearch) -> first();

        $workoutDB = new Workout();

        $workoutData = [
            'type' => $io->choice("Workout type:", ['Individual', 'Group']),
            'duration' => (int)$io->ask("Workout duration(min):"),
            'rest_time' => (int)$io->ask("Rest time(sec):"),
            'place' => $io->choice("Workout place:", ['Gym', 'Stadium', 'Home']),
            'method' => $io->choice("Workout method:", ['Interval', 'Variable', 'Circular']),
            'client_id' => $client,
        ];

        $workoutDB->set($workoutData);
        $workoutDB->insert();


        $io->table($workoutDB->fields(), $workoutDB->findAll(true));

        return Command::SUCCESS;
    }
}