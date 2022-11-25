<?php

namespace Manikienko\Todo\Commands;

use Lazer\Classes\Database as Lazer;
use Lazer\Classes\Helpers\Config;
use Lazer\Classes\Helpers\Data;
use Manikienko\Todo\Database\ClientDatabase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/* надо переименовать в CreateCommand*/
class CreateClientCommand extends Command
{

    public function configure()
    { 
        parent::configure();
        $this->setName('client');

    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->text('Create new user');

        $clientsDB = new ClientDatabase();

        $userData = [
            'name' => $io->ask("User name:"),
            'age' => (int)$io->ask("User age:"),
            'status' => $io->choice("User status:", ['active', 'inactive']),
        ];

        $clientsDB->set($userData);
        $clientsDB->insert();


        $io->table($clientsDB->fields(), $clientsDB->findAll(true));

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
