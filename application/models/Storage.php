<?php
namespace application\models;
use application\exceptions\StorageException;
class Storage
{
    public static function get_products()
    {
        return include_once(ROOT.'/storage.php');
    }

    public static function get_product_by_id($id)
    {
        $products = include_once(ROOT.'/storage.php');
        foreach ($products as $key => $product) {
            if ($product['id'] == $id) {
                return array($key => $product);
            }
        }

        throw new StorageException("Product " . $id . " doesn't exist.");
    }
}