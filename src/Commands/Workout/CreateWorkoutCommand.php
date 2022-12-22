<?php


namespace Manikienko\Todo\Commands\Workout;

use Manikienko\Todo\Model\Client;
use Manikienko\Todo\Model\Workout;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateWorkoutCommand extends Command
{

    public function configure()
    {
        parent::configure();
        $this->setName('workout:create');

    }

    public function chooseClient(string $message, SymfonyStyle $io): string|int|false
    {
        $clients = Client::query()->findAll()->pluck('name', 'id');
        foreach ($clients as $id => $clientName) {
            $clients[$id] = "$id. $clientName";
        }

        $value = $io->choice($message, $clients);
        // ->choice() может тебе вернуть и ключ и значение, а значит надо позаботиться о том, что это будет точно ID клиента
        if (!is_int($value)) {
            $id = array_search($value, $clients);
        }

        return $id;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->text('Create new workout');

        $newWorkout = new Workout();

        $workoutData = [
            // мы сделаем по другому, выборка из всех возможных клиентов.
            'client_id' => $this->chooseClient('Choose client:', $io),
            'type' => $io->choice("Workout type:", ['Individual', 'Group']),
            'duration' => (int)$io->ask("Workout duration(min):"),
            'rest_time' => (int)$io->ask("Rest time(sec):"),
            'place' => $io->choice("Workout place:", ['Gym', 'Stadium', 'Home']),
            'method' => $io->choice("Workout method:", ['Interval', 'Variable', 'Circular']),
        ];

        $newWorkout->set($workoutData);
        $newWorkout->insert();

        // $newWorkout == $lastWorkout, только в $lastWorkout ещё подгружен клиент
        $lastWorkout = Workout::query()
            ->with(Client::getTableName())
            ->last();

        [$tableData] = $lastWorkout->asArray();

        // поле Clients это связь которую мы подгрузили через ->with(Client::getTableName())
        // Название поля связи это название таблицы в PascalCase
        // тут мы превращаем клиента в результате из массива в название, чтобы можно было потом отрисовать правильно в таблице.
        $tableData['Clients'] = $tableData['Clients']->name;

        $io->table(array_keys($tableData), [$tableData]);

        /*todo Дополни команду client:read - добавь туда после вывода данных о клиенте ещё список его тренировок*/

        return Command::SUCCESS;
    }
}