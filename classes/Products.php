<?php
class Product_id_not_exists extends Exception {}
class Products {
    private $products;
    public function __construct($products) {
        $this->products = $products;
    }

    public function get_product($id) {
        if (array_key_exists($id, $this->products)) return $this->products[$id];
        else throw new Product_id_not_exists("Product ".$id." doesn't exist.");
    }
}