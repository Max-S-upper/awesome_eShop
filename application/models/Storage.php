<?php
namespace application\models;

use application\exceptions\StorageException;

class Storage
{
    public static function getProductById($id)
    {
        $products = include(ROOT.'/storage.php');
        foreach ($products as $key => $product) {
            if ($product['id'] == $id) {
                return $product;
            }
        }
    }

    public static function getIds() {
        $products = include(ROOT.'/storage.php');
        foreach ($products as $product) {
            $ids[] = $product['id'];
        }

        return $ids;
    }
}