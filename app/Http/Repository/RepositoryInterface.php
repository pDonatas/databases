<?php

namespace App\Http\Repository;

interface RepositoryInterface
{
    public function findAll();

    public function find(int $id);

    public function findBy(string $key, mixed $value);
}
