<?php

namespace Manikienko\Todo\Commands;

use Lazer\Classes\Helpers\Config;
use Lazer\Classes\Helpers\Data;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Lazer\Classes\Database as Lazer;

class UpdateCommand extends Command
{
    private SymfonyStyle $io;

    public function configure()
    {
        parent::configure();
        $this->setName('update');
        $this->addArgument('id'); 
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->io = new SymfonyStyle($input, $output);
        $this->io->text('Update user by id');
        $input->getArgument('id');


        if (!$this->tableExists('users')) {
            $this->createUsersTable();
        }

        $this->updateNewUser([
            'name' => $this->io->ask("User new name:"),
            'age' => (int) $this->io->ask("User new age:"),
            'status' => $this->io->choice("User new status:", ['active', 'inactive']),
        ]);

        $table = Lazer::table('users')->findAll();

        $rows = [];
        foreach ($table as $row) {
            $rows[] = (array) $row;
        }

        $this->io->table($table->fields(), $rows);

        return Command::SUCCESS;
    }
    public function tableExists(string $tableName): bool
    {
        return Config::table($tableName)->exists() && Data::table($tableName)->exists();
    }
    public function createUsersTable()
    {
        Lazer::create('users', [
            'name' => 'string',
            'age' => 'integer',
            'status' => 'string',
        ]);
    }

    private function updateNewUser(array $array)
    {
        $database = Lazer::table('users')->find('id');
        $database->set($array);

        $database->save();
    }
}

    ///
//$row = Lazer::table('users')->find(1);

//$row->set(array(
    //'nickname' => 'user',
    //'email' => 'user@example.com'
//));
//$row->save();