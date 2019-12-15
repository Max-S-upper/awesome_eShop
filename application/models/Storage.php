<?php
namespace application\models;

use application\exceptions\StorageException;

class Storage
{
    public static function getProducts()
    {
        return include_once(ROOT.'/storage.php');
    }

    public static function getProductById($id)
    {
        $products = include_once(ROOT.'/storage.php');
        foreach ($products as $key => $product) {
            if ($product['id'] == $id) {
                $product['name'] = $key;
                return $product;
            }
        }

        throw new StorageException("Product " . $id . " doesn't exist.");
    }
}