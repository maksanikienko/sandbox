#!/usr/bin/env php
<?php
require __DIR__.'/vendor/autoload.php';

//Workout
use Manikienko\Todo\Commands\Workout\CreateWorkoutCommand;
//Gym
use Manikienko\Todo\Commands\Gym\CreateGymCommand;
//Trainer
use Manikienko\Todo\Commands\Trainer\CreateTrainerCommand;
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
//gym
$application->add(new CreateGymCommand());
//trainer
$application->add(new CreateTrainerCommand());
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