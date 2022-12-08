<?php

namespace Manikienko\Todo\Commands\Database;

use Lazer\Classes\Database;
use Manikienko\Todo\Database\AbstractMigration;
use Manikienko\Todo\Database\Schema;
use Manikienko\Todo\Model\Migration;
use ReflectionClass;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MigrationsRollbackCommand extends Command
{

    public function configure()
    {
        parent::configure();
        $this->setName('migrations:rollback');
    }

    public function getMigrationClassName(object $migration): string
    {
        // ex: \Manikienko\Todo\Database\Version16704974761789
        $baseMigration = new ReflectionClass(AbstractMigration::class);
        return $baseMigration->getNamespaceName() . "\\Version" . $migration->version;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        if (!Migration::tableExists()) {
            $io->section("<comment>Noting to rollback.</comment>");

            return Command::INVALID;
        }

        $lastMigration = Migration::query()->last();

        /** @var Migration[]|\stdClass[]|Database $migrationBatch */
        $migrationBatch = Migration::query()
            ->where('batch', '=', $lastMigration->batch)
            ->orderBy('id', 'DESC')
            ->findAll();

        foreach ($migrationBatch as $migration) {
            $migrationClassName = $this->getMigrationClassName($migration);

            $migrationClass = new $migrationClassName();
            $migrationClass->down(new Schema());

            $io->writeln(
                "<info>[DONE]</info> " .
                "Migration <comment>'{$migration->version}'</comment> from " .
                "<comment>'$migration->batch'</comment> batch was rolled back."
            );

            if (!Migration::tableExists()) {
                $io->section('It was the last migration. Database was completely deleted.');
                return Command::SUCCESS;
            } else {
                Migration::query()->delete($migration->id);
            }

        }

        return Command::SUCCESS;
    }
}
