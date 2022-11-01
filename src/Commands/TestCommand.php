<?php
namespace Manikienko\Todo\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Lazer\Classes\Database as Lazer; // example

class TestCommand extends Command
{
    public function configure()
    {
        parent::configure();
        $this->setName('test:command');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->ask("Please provide item name:");
        //$io->choice('Choose workout type:', ['heavy', 'full-body', 'jogging']);
        //$io->comment(...);
        //$io->error('Error');
        //$io->info('...');
        $io->success('Your command works.');

Lazer::create('users', [
    'id' => 'integer',
    'nickname' => 'string',
]);

try{
    \Lazer\Classes\Helpers\Validate::table('users')->exists();
} catch(\Lazer\Classes\LazerException $e){
    //Database doesn't exist
}

$row = Lazer::table('users');

$row ->id = '10';
$row->nickname = 'new_user2';
$row->save();

$table = Lazer::table('users')->findAll();
    
foreach($table as $row)
{
    print_r($row);
}

        return Command::SUCCESS;
    }
}
