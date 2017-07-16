<?php

namespace App\Collections;



use triagens\ArangoDb\Statement;

class ClienteRepository extends ArangoCollectionRepository
{
    public $collection = "clientes";

    public function validate(array $input): bool
    {
        return true;
    }
}