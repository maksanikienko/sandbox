#!/usr/bin/env php
<?php
require __DIR__.'/vendor/autoload.php';

use Manikienko\Todo\Commands\CreateWorkoutCommand;
use Manikienko\Todo\Commands\CreateGymCommand;
use Manikienko\Todo\Commands\CreateTrainerCommand;
use Manikienko\Todo\Commands\Database\MigrationCreateCommand;
use Manikienko\Todo\Commands\Database\MigrationsRollbackCommand;
use Manikienko\Todo\Commands\Database\MigrationsRunCommand;
use Manikienko\Todo\Commands\ReadExerciseCommand;
use Manikienko\Todo\Commands\DeleteExerciseCommand;
use Manikienko\Todo\Commands\UpdateExerciseCommand;
use Manikienko\Todo\Commands\CreateExerciseCommand;
use Manikienko\Todo\Commands\CreateClientCommand;
use Manikienko\Todo\Commands\UpdateClientCommand;
use Symfony\Component\Console\Application;

define('LAZER_DATA_PATH', realpath(__DIR__).'/data/');
@mkdir(LAZER_DATA_PATH);

$application = new Application();
// тут с помощью $application->add(...) ты будешь добавлять новые команды
$application->add(new CreateWorkoutCommand());
$application->add(new CreateGymCommand());
$application->add(new CreateTrainerCommand());
$application->add(new ReadExerciseCommand());
$application->add(new DeleteExerciseCommand());
$application->add(new UpdateExerciseCommand());
$application->add(new CreateExerciseCommand());
$application->add(new CreateClientCommand());
$application->add(new UpdateClientCommand());
//$application->add(new GenerateAdminCommand());

// database commands
$application->add(new MigrationCreateCommand());
$application->add(new MigrationsRunCommand());
$application->add(new MigrationsRollbackCommand());

$application->run();