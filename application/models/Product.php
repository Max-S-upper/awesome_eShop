<?php
namespace application\models;

class Product
{
    public function getById($id)
    {
        $product = Storage::getProductById($id);
        foreach ($product as $key => $productItem) {
            $this->$key = $productItem;
        }
    }
}