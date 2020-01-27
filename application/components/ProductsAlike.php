<?php


namespace application\components;


use application\models\Product;
use core\HelperPattern;

class ProductsAlike extends HelperPattern
{
    public function getHtml($productId)
    {
        $stmt = $this->db->connection->query("select products.* from products left join products_alike on 
            products_alike.first_product_id = products.id where products_alike.second_product_id = $productId");
        if (!$stmt->rowCount()) {
            $stmt = $this->db->connection->query("select products.* from products left join products_alike on 
                products_alike.second_product_id = products.id where products_alike.first_product_id = $productId");
        }

        if ($stmt) $productsAlikeData = $stmt->fetchAll();
        $productsAlike = array();
        foreach ($productsAlikeData as $productAlikeData) {
            $product = new Product();
            $productAlike = $product->setProductData($productAlikeData);
            $productsAlike[] = $productAlike;
        }

        return $productsAlike;
    }
}