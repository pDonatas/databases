<?php

namespace App\Http\Repository\Neo4j;

use App\Http\Factory\Neo4jEntityFactory;
use Laudis\Neo4j\Client;
use Laudis\Neo4j\Databags\Statement;

class BaseNeoRepository
{
    public function __construct(public Client $client) {}

    public function getLastId(string $label): int
    {
        $result = $this->client->runStatement(Statement::create("MATCH (n:$label) RETURN MAX(n.id)"));

        return $result->get(0)->get('MAX(n.id)');
    }
}
