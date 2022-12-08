<?php

namespace Manikienko\Todo\Commands\Database;

use Iterator;
use Manikienko\Todo\Database\AbstractMigration;
use Manikienko\Todo\Database\Schema;
use Manikienko\Todo\Model\Migration;
use ReflectionClass;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class MigrationsRunCommand extends Command
{

    public function configure()
    {
        parent::configure();
        $this->setName('migrations:run');
    }

    /**
     * @return int
     */
    public function getBatchID(): int
    {
        return time();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $batch = $this->getBatchID();

        $nothingMigrated = true;
        foreach ($this->listMigrationFiles() as $file) {
            /** @var AbstractMigration $migrationClass */
            $class = $this->getMigrationClassName($file);

            $migrationClass = new $class();
            if ($this->migrationWasExecuted($migrationClass)) {
                continue;
            }

            $nothingMigrated = false;
            $migrationClass->up(new Schema());

            $migration = $this->createMigration($migrationClass, $batch);

            $io->writeln(
                "<info>[DONE]</info> " .
                "<comment>{$migration->version}</comment> migrated as a part of <info>$migration->batch</info> batch"
            );
        }

        if ($nothingMigrated) {
            $io->section("<comment>Nothing to migrate</comment>");

        }

        return Command::SUCCESS;
    }

    private function createMigration(AbstractMigration $migrationClass, int $batch): Migration
    {
        $migration = new Migration();
        $migration->version = $migrationClass->getVersion();
        $migration->batch = $batch;
        $migration->time = time();
        $migration->save();

        return $migration;
    }

    public function migrationWasExecuted(AbstractMigration $migrationClass): bool
    {
        return Migration::tableExists()
            && Migration::query()->where('version', '=', $migrationClass->getVersion())->exists();
    }

    /**
     * @return Iterator<string, SplFileInfo>
     */
    public function listMigrationFiles(): Iterator
    {
        return (new Finder())
            ->in(__DIR__ . '/../../../migrations')
            ->name('Version*.php')
            ->sortByName()
            ->getIterator();
    }

    public function getMigrationClassName(SplFileInfo $file): string
    {
        $reflectionClass = new ReflectionClass(AbstractMigration::class);
        return $reflectionClass->getNamespaceName() . "\\" . $file->getFilenameWithoutExtension();
    }
}
