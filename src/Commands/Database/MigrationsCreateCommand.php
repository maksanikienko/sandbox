<?php

namespace Manikienko\Todo\Commands\Database;

use Manikienko\Todo\Database\AbstractMigration;
use ReflectionClass;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MigrationsCreateCommand extends Command
{

    public function configure()
    {
        parent::configure();
        $this->setName('migrations:create');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $migrationsClassName = $this->generateMigrationName();
        $migrationContent = $this->prepareClassSignature($migrationsClassName);

        file_put_contents($this->getMigrationFileFullPath($migrationsClassName), $migrationContent);

        $io->section("<info>[DONE]</info> Migration was created at <comment>./migrations/$migrationsClassName</comment>");

        return Command::SUCCESS;
    }

    public function getMigrationFileFullPath(string $migrationsClassName): string
    {
        return realpath("{$this->getSourceFolderPath()}/../migrations") . "/$migrationsClassName.php";
    }

    /**
     * @return array|string|string[]
     */
    public function generateMigrationName(): string|array
    {
        //ex: 1670498833.2588
        $timestamp = (string)microtime(true);

        // Version16704988332588
        $version = str_replace(".", "", "Version" . $timestamp);

        $className = str_pad($version, 15, '0', STR_PAD_RIGHT);

        return $className;
    }

    /**
     * @return string
     */
    public function getSourceFolderPath(): string
    {
        return __DIR__ . '/../..';
    }

    public function prepareClassSignature(string $migrationsClassName): string
    {
        $reflectionClass = new ReflectionClass(AbstractMigration::class);
        $baseMigrationPath = ($reflectionClass)->getFileName();
        $migrationContent = file_get_contents($baseMigrationPath);

        return str_replace(
            "abstract class {$reflectionClass->getShortName()} extends Migration",
            "class $migrationsClassName extends \Manikienko\Todo\Database\AbstractMigration",
            $migrationContent
        );
    }
}
