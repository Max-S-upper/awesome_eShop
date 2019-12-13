<?php
namespace application\models;
//include_once(ROOT.'/exceptions.php');
use application\Product_id_not_exists;
class Storage {
    public static function get_products() {
        return include_once(ROOT.'/storage.php');
    }

    public static function get_product_by_id($id) {
        $products = include_once(ROOT.'/storage.php');
        foreach ($products as $key => $product) {
            if ($product['id'] == $id) {
                return array($key => $product);
            }
        }

        throw new Product_id_not_exists("Product " . $id . " doesn't exist.");
    }
}