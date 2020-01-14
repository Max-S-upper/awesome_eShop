<?php


namespace application\models;


class ProductAlike extends ActiveRecordEntity
{
    public function getByProductId($productId)
    {
        $productsAlikeDataForFirstPosition = $this->db->connection->query("SELECT second_product_id FROM products_alike WHERE first_product_id = $productId")->fetchAll();
        $productsAlikeDataForSecondPosition = $this->db->connection->query("SELECT first_product_id FROM products_alike WHERE second_product_id = $productId")->fetchAll();
        $productsAlikeData = array_merge($productsAlikeDataForFirstPosition, $productsAlikeDataForSecondPosition);
        $productsAlike = [];
        foreach ($productsAlikeData as $productAlikeData) {
            $productAlike = new ProductAlike();
            $productAlike->id = $productAlikeData[0];
            $productsAlike[] = $productAlike;
        }

        return $productsAlike;
    }

    public function getTableName()
    {
        return 'products_alike';
    }
}