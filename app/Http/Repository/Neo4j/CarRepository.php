<?php declare(strict_types=1);

namespace App\Http\Repository\Neo4j;

use App\Http\Factory\Neo4jEntityFactory;
use App\Http\Repository\RepositoryInterface;
use App\Models\Car;
use Laudis\Neo4j\Databags\Statement;

class CarRepository extends BaseNeoRepository implements RepositoryInterface
{
    public function findAll(): array
    {
        $result = $this->client->runStatement(Statement::create('MATCH (n:Car) RETURN n'));

        $data = [];

        foreach($result as $item) {
            $data[] = Neo4jEntityFactory::create($item);
        }

        return $data;
    }

    public function create(array $data): Car
    {
        $data['id'] = $this->getLastId('Car') + 1;

        $this->client->run('CREATE (n:Car) SET n += $carInfo', ['carInfo' => $data]);

        return $this->find($data['id']);
    }

    public function find(int $id): Car
    {
        $result = $this->client->runStatement(Statement::create('MATCH (n:Car) WHERE n.id = '. $id .' RETURN n'));

        return  Neo4jEntityFactory::create($result->get(0));
    }

    public function findBy(string $key, mixed $value): array
    {
        $result = $this->client->runStatement(Statement::create("MATCH (n:Car) WHERE n.$key = $value RETURN n"));

        $data = [];

        foreach($result as $item) {
            $data[] = Neo4jEntityFactory::create($item);
        }

        return $data;
    }

    public function update(array $data, int $id)
    {
        $this->client->run('MATCH (n:Car{id:'.$id.'}) SET n += $carInfo', ['carInfo' => $data]);

        return $this->find($id);
    }

    public function delete(int $car)
    {
        $this->client->runStatement(
            Statement::create('MATCH (n:Car{id: '. $car.'}) DETACH DELETE(n)')
        );
    }
}
