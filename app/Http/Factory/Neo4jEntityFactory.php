<?php

namespace App\Http\Factory;

use Illuminate\Database\Eloquent\Model;
use Laudis\Neo4j\Types\CypherMap;

class Neo4jEntityFactory
{
    public static function create(CypherMap $map, string $selector = 'n', string $namespace = '\App\Models\\'): Model
    {
        $list = $map->get($selector);

        $model = str_replace(['_', ' '], '', $list->getLabels()->first());

        $class = $namespace.$model;

        $object = app($class);

        foreach($list->getProperties() as $key => $value) {
            $object->$key = $value;
        }

        return $object;
    }
}
