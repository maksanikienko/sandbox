<?php

namespace Manikienko\Todo\Commands;

use Lazer\Classes\Helpers\Config;
use Lazer\Classes\Helpers\Data;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Lazer\Classes\Database as Lazer;

class TestCommand extends Command
{
    private SymfonyStyle $io;

    public function configure()
    {
        parent::configure();
        $this->setName('create');

    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->io = new SymfonyStyle($input, $output);
        $this->io->text('Create new user');

        if (!$this->tableExists('users')) {
            $this->createUsersTable();
        }

        
        $this->createNewUser([
            'name' => $this->io->ask("User name:"),
            'age' => (int) $this->io->ask("User age:"),
            'status' => $this->io->choice("User status:", ['active', 'inactive']),
        ]);
        //$this->io->horizontalTable(
           // ['Name','Age','Status'],
           // [
           //     ['name' => $this->io->ask("User name:"),'age' => (int) $this->io->ask("User age:"),'status' => $this->io->choice("User status:", ['active', 'inactive'])],
           // ]
        //);

        // тут мы просим подгрузить данные в память для того, чтобы потом их итерировать.
        // Обычно вызывая подобные методы мы получаем набор сущностей, коллекцию, но не тут.
        // Тут он подгружает данные внутрь класса таблицы (\Lazer\Classes\Database) и позволяет проитерировать их.
        $table = Lazer::table('users')->findAll();

        # важный момент, пакет исплользует stdClass под капотом, так что данные надо вначале превартить в массив,
        # чтобы легче было работать. К примеру так: (array) $row
        $rows = [];
        foreach ($table as $row) {
            $rows[] = (array) $row;
        }

        // а теперь немного магии symfony
        $this->io->table($table->fields(), $rows);

        return Command::SUCCESS;
    }


    public function tableExists(string $tableName): bool
    {
        // посмотри \Lazer\Classes\Helpers\Validate::exists
        // там почти такой же код, но он использует исключения, тут мы используем булеву алгебрку (ИСТИНА * ИСТИНА = ИСТИНА)

        return Config::table($tableName)->exists() && Data::table($tableName)->exists();
    }

    public function createUsersTable()
    {
        # Тут мы объявляем таблицы.
        #  Lazer::create('название таблицы', [
        #      'название поля' => 'тип данных'
        #       ...
        #  ]);

        # Пару советов:
        # 1. В таблице должен быть обязательно уникальный идентификатор. В зависимости от данных что
        # ты хранишь это может: ISBN, IDNP, номер автомобиля, MAC аддресс девайса, номер квартиры, и.тд.
        # Чаще всего используется id типа integer - по сути это порядковый номер. Иногда используется UUID, но я тебе об
        # этом расскажу позже, когда будем изучать SQL базы данных
        # 2. В таблице используются поля created_at и updated_at чтобы знать когда запись была созадана и
        # когда она была обновлнеа. Тип данных integer (смотри функцию time()).
        # 3. На каждую сущность нужна отдельная таблица. В твоём случае у тебя есть следующие сущности: клиент, тренер, тренировка (пока что 3)
        # 4. Так как между сущностями есть связи нам их надо как-то обьявлять: Есть несколько видов связей, в зависимости соотношения между сущностями:
        #    - one-to-one: у клиента есть один тренер, у автомобиля один водитель, у компьютера один экран и тд
        #    - one-to-many: у тренера есть много клиентов, у тренера есть много тренировок, у клиента есть много тренировок
        #    - many-to-many: тут сложнее - что-то в духе у квартиры может быть несколько хозяев и у хозяева может быть несколько квартир
        #
        # Вот тебе немного материалов, советую записывать термины и потом пытаться обьяснить их своими словами:
        # - https://youtu.be/wR0jg0eQsZA
        # - https://youtu.be/QpdhBUYk7Kk
        # - https://www.youtube.com/watch?v=-CuY5ADwn24&t=37s
        # - https://www.youtube.com/watch?v=GFQaEYEc8_8
        # - https://www.youtube.com/watch?v=wOD02sezmX8
        # - https://www.youtube.com/watch?v=n3mHfQft5P8

        Lazer::create('users', [
            // тут мы указываем структуру таблицы
            // название поля => тип данных
            'name' => 'string',
            'age' => 'integer',
            'status' => 'string',
            // поле id не обязательно, оно тут будет по умолчанию обьявлено под капотом
        ]);
    }

    private function createNewUser(array $array)
    {
        // это пример атомарного подхода, он не создаст тебе проблем.
        // (под атомарным я имею ввиду что всё делается в (почти) одну операцию)

        $database = Lazer::table('users');
        $database->set($array);

        # save() будет проверять если у записи есть id. Если он есть, значит ты делаешь update.
        # insert() просто вставить запись в БД как новую
        $database->insert();
    }
}
