<?php


namespace core;


class HelperPattern
{
    protected $db;
    public function __construct()
    {
        $this->db = new Db;
    }
}