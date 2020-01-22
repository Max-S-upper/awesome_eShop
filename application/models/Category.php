<?php


namespace application\models;


class Category extends ActiveRecordEntity
{
    public $id;
    public $title;

    public function getTableName()
    {
        return 'categories';
    }
}