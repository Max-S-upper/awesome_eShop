<?php
//namespace application\models;
//
//class Product
//{
//    public $id;
//    public $picture;
//    public $name;
//    public $quantity;
//    public $price;
//    public $brand;
//    public $description;
//    public function getById($id)
//    {
//        $product = Storage::getProductById($id);
//        foreach ($product as $key => $productItem) {
//            $this->$key = $productItem;
//        }
//    }
//
//    public function getProducts()
//    {
//        $products = array();
//        foreach (Storage::getIds() as $id) {
//            $productItem = Storage::getProductById($id);
//            $product = new self();
//            $product->id = $productItem['id'];
//            $product->name = $productItem['name'];
//            $product->picture = $productItem['picture'];
//            $product->quantity = $productItem['quantity'];
//            $product->price = $productItem['price'];
//            $product->brand = $productItem['brand'];
//            $product->description = $productItem['description'];
//            $products[] = $product;
//        }
//
//        return $products;
//    }
//
//    public function getByBrand($brand)
//    {
//        $products = array();
//        foreach (Storage::getIds() as $id) {
//            $productItem = Storage::getProductById($id);
//            if ($productItem['brand'] == $brand) {
//                $product = new self();
//                $product->id = $productItem['id'];
//                $product->name = $productItem['name'];
//                $product->picture = $productItem['picture'];
//                $product->quantity = $productItem['quantity'];
//                $product->price = $productItem['price'];
//                $product->brand = $productItem['brand'];
//                $product->description = $productItem['description'];
//                $products[] = $product;
//            }
//        }
//
//        return $products;
//    }
//}