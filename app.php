#!/usr/bin/env php
<?php
require __DIR__.'/vendor/autoload.php';

//Workout
use Manikienko\Todo\Commands\Workout\CreateWorkoutCommand;
use Manikienko\Todo\Commands\Workout\UpdateWorkoutCommand;
use Manikienko\Todo\Commands\Workout\DeleteWorkoutCommand;
use Manikienko\Todo\Commands\Workout\ReadWorkoutCommand;
//Gym
use Manikienko\Todo\Commands\Gym\CreateGymCommand;
use Manikienko\Todo\Commands\Gym\UpdateGymCommand;
use Manikienko\Todo\Commands\Gym\DeleteGymCommand;
use Manikienko\Todo\Commands\Gym\ReadGymCommand;
//Trainer
use Manikienko\Todo\Commands\Trainer\CreateTrainerCommand;
use Manikienko\Todo\Commands\Trainer\UpdateTrainerCommand;
use Manikienko\Todo\Commands\Trainer\ReadTrainerCommand;
use Manikienko\Todo\Commands\Trainer\DeleteTrainerCommand;
//Migration
use Manikienko\Todo\Commands\Database\MigrationCreateCommand;
use Manikienko\Todo\Commands\Database\MigrationsRollbackCommand;
use Manikienko\Todo\Commands\Database\MigrationsRunCommand;
//Exercise
use Manikienko\Todo\Commands\Exercise\ReadExerciseCommand;
use Manikienko\Todo\Commands\Exercise\DeleteExerciseCommand;
use Manikienko\Todo\Commands\Exercise\UpdateExerciseCommand;
use Manikienko\Todo\Commands\Exercise\CreateExerciseCommand;
//Client
use Manikienko\Todo\Commands\Client\CreateClientCommand;
use Manikienko\Todo\Commands\Client\UpdateClientCommand;
use Manikienko\Todo\Commands\Client\ReadClientCommand;
use Manikienko\Todo\Commands\Client\DeleteClientCommand;


use Symfony\Component\Console\Application;

define('LAZER_DATA_PATH', realpath(__DIR__).'/data/');
@mkdir(LAZER_DATA_PATH);

$application = new Application();
//workout
$application->add(new CreateWorkoutCommand());
//$application->add(new UpdateWorkoutCommand());
//$application->add(new DeleteWorkoutCommand());
//$application->add(new ReadWorkoutCommand());
//gym
$application->add(new CreateGymCommand());
$application->add(new UpdateGymCommand());
$application->add(new DeleteGymCommand());
$application->add(new ReadGymCommand());
//trainer
$application->add(new CreateTrainerCommand());
$application->add(new UpdateTrainerCommand());
$application->add(new DeleteTrainerCommand());
$application->add(new ReadTrainerCommand());
//exercise
$application->add(new ReadExerciseCommand());
$application->add(new DeleteExerciseCommand());
$application->add(new UpdateExerciseCommand());
$application->add(new CreateExerciseCommand());
//client
$application->add(new CreateClientCommand());
$application->add(new UpdateClientCommand());
$application->add(new ReadClientCommand());
$application->add(new DeleteClientCommand());

// database commands
$application->add(new MigrationCreateCommand());
$application->add(new MigrationsRunCommand());
$application->add(new MigrationsRollbackCommand());

$application->run();