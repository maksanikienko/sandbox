<?php


namespace Manikienko\Todo\Commands;

use Lazer\Classes\Database as Lazer;
use Lazer\Classes\Helpers\Config;
use Lazer\Classes\Helpers\Data;
use Manikienko\Todo\Database\ExerciseDatabase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/* надо переименовать в CreateCommand*/
class CreateExerciseCommand extends Command
{

    public function configure()
    {
        parent::configure();
        $this->setName('exercise');

    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->text('Create new exercise');

        $exerciseDB = new ExerciseDatabase();

        $userData = [
            'name' => $io->ask("Exercise name:"),
            'difficultyScale' => $io->ask("Exercise rating:"),
            'type' => $io->choice("Exercise type:", ['Base', 'Isolate']),
            'level' => $io->choice("Exercise level:", ['Easy', 'Normal', 'Hard']),
            'weightType' => $io->choice("Exercise Weight:", ['Barbell', 'Dumbell', 'Machine']),
        ];

        $exerciseDB->set($userData);
        $exerciseDB->insert();


        $io->table($exerciseDB->fields(), $exerciseDB->findAll(true));

        return Command::SUCCESS;
    }

    public function tableExists(string $tableName): bool
    {

        return Config::table($tableName)->exists() && Data::table($tableName)->exists();
    }
    public function createExerciseTable()
    {
        Lazer::create('Exercise', [
            'name' => 'string',
            'difficultyScale' => 'integer',
            'type' => 'string',
            'level' => 'string',
            'weightType' => 'string',
        ]);
    }

    private function createNewExercise(array $array)
    {

        $database = Lazer::table('Exercise');
        $database->set($array);
        $database->insert();
    }
}