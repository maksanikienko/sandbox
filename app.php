#!/usr/bin/env php
<?php
require __DIR__.'/vendor/autoload.php';

use Manikienko\Todo\Commands\TestCommand;
use Symfony\Component\Console\Application;
define('LAZER_DATA_PATH', realpath(__DIR__).'/data/');
@mkdir(LAZER_DATA_PATH);

$application = new Application();
// тут с помощью $application->add(...) ты будешь добавлять новые команды

$application->add(new TestCommand());
//$application->add(new GenerateAdminCommand());

$application->run();