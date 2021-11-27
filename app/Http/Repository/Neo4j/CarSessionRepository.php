<?php declare(strict_types=1);

namespace App\Http\Repository\Neo4j;

use App\Http\Factory\Neo4jEntityFactory;
use App\Http\Repository\RepositoryInterface;
use App\Models\Session;
use Laudis\Neo4j\Databags\Statement;

class CarSessionRepository extends BaseNeoRepository implements RepositoryInterface
{
    public function countActiveSessions(int $userId): int
    {
        $result = $this->client->runStatement(
            Statement::create('MATCH (n:Session) WHERE n.user_id = '. $userId .' AND n.active = 1 RETURN COUNT(n)')
        );

        return $result->get(0)->get('COUNT(n)') ?? 0;
    }

    public function create(array $data): Session
    {
        $data['id'] = $this->getLastId('Session') + 1;
        $data['active'] = 1;

        $this->client->run('CREATE (n:Session) SET n += $carInfo', ['carInfo' => $data]);

        return $this->find($data['id']);
    }

    public function deleteSessions(int $car): void
    {
        $this->client->runStatement(
            Statement::create('MATCH (n:Session{car_id: '. $car.'}) DETACH DELETE(n)')
        );
    }

    public function stopRents(int $id, int $carId = 0): void
    {
        if ($carId == 0) {
            $this->client->runStatement(
                Statement::create('MATCH (n:Session{user_id: ' . $id . ', active: 1}) SET n.active = 0')
            );
        } else {
            $this->client->runStatement(
                Statement::create('MATCH (n:Session{user_id: ' . $id . ', car_id: '. $carId .', active: 1}) SET n.active = 0')
            );
        }
    }

    public function isUserHasRentForCar(int $userId, int $carId): bool
    {
        $result = $this->client->runStatement(
            Statement::create('MATCH (n:Session{user_id: '. $userId.', car_id: '. $carId .', active: 1}) RETURN COUNT(n)')
        );

        return $result->get(0)->get('COUNT(n)') > 0;
    }

    public function findAll(): array
    {
        $result = $this->client->runStatement(Statement::create('MATCH (n:Session) RETURN n'));

        $data = [];

        foreach($result as $item) {
            $data[] = Neo4jEntityFactory::create($item);
        }

        return $data;
    }

    public function find(int $id): Session
    {
        $result = $this->client->runStatement(Statement::create('MATCH (n:Session) WHERE n.id = '. $id .' RETURN n'));

        return Neo4jEntityFactory::create($result->get(0));
    }

    public function findBy(string $key, mixed $value): array
    {
        $result = $this->client->runStatement(Statement::create("MATCH (n:Session) WHERE n.$key = $value RETURN n"));

        $data = [];

        foreach($result as $item) {
            $data[] = Neo4jEntityFactory::create($item);
        }

        return $data;
    }
}
