<?php


namespace application\models;

class ProductAttribute extends ActiveRecordEntity
{
    public function getAttributesIdByProductId($productId)
    {
        $productAttributes = [];
        foreach ($this->db->connection->query("SELECT attribute_id FROM products_attributes WHERE product_id = $productId")->fetchAll() as $productAttributeData) {
            $productAttribute = new ProductAttribute();
            $productAttribute->attributeId = $productAttributeData['attribute_id'];
            $productAttributes[] = $productAttribute;
        }

        return $productAttributes;
    }

    public function getTableName()
    {
        return 'products_attributes';
    }
}