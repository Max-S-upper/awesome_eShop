<?php

namespace config;

class Db
{
    public $connection;
    public function __construct()
    {
        $this->connection = new \PDO('mysql:host=localhost;dbname=max_db', 'max', 'Maso88769202');
    }
}