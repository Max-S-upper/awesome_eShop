<?php

namespace application\models;

class Product  extends ActiveRecordEntity
{
    public function getAll()
    {
        $products = array();
        foreach ($this->db->connection->query("SELECT * FROM " . $this->getTableName())->fetchAll() as $product) {
            $brandObject = new Brand();
            $brandTitle = $brandObject->getTitle($product['brand_id']);
            $productAttributesObject = new ProductAttribute();
            $productAttributes = $productAttributesObject->getAttributesIdByProductId($product['id']);
            $attributeObject = new Attribute();
            $attributes = array();
            foreach ($productAttributes as $productAttribute) {
                $attributes[] = $attributeObject->getTitle($productAttribute->attributeId);
            }

            $productObject = new self();
            $productObject->id = $product['id'];
            $productObject->title = $product['title'];
            $productObject->description = $product['description'];
            $productObject->sale_price = $product['sale_price'];
            $productObject->code = $product['code'];
            $productObject->brand_id = $product['brand_id'];
            $productObject->is_sale = $product['is_sale'];
            $productObject->image = $product['image'];
            $productObject->brand = $brandTitle;
            $productObject->brand_id = $product['brand_id'];
            $productObject->price = $product['price'];
            $productObject->quantity = $product['quantity'];
            $productObject->attributes = $attributes;
            $products[] = $productObject;
        }

        return $products;
    }

    public function getById($id)
    {
        $product = $this->db->connection->query("SELECT * FROM " . $this->getTableName() . " WHERE id = $id")->fetchAll()[0];
        $brandObject = new Brand();
        $brandTitle = $brandObject->getTitle($product['brand_id']);
        $productAttributesObject = new ProductAttribute();
        $productAttributes = $productAttributesObject->getAttributesIdByProductId($product['id']);
        $attributeObject = new Attribute();
        $attributes = array();
        foreach ($productAttributes as $productAttribute) {
            $attributes[] = $attributeObject->getTitle($productAttribute->attributeId);
        }

        $productAlikeObject = new ProductAlike();
        $productsAlike = [];
        foreach ($productAlikeObject->getByProductId($product['id']) as $productAlike) {
            $productAttribute = new ProductAttribute();
            $productAttributes = $productAttribute->getAttributesIdByProductId($productAlike->id);
            foreach ($productAttributes as $productAttribute) {
                $attributeObject = new Attribute();
                $attribute = $attributeObject->getTitle($productAttribute->attributeId);
                $productsAlike[] = [
                    'id' => $productAlike->id,
                    'title' => $attribute->title
                ];
            }
        }

        $productObject = new self();
        $productObject->id = $product['id'];
        $productObject->title = $product['title'];
        $productObject->description = $product['description'];
        $productObject->sale_price = $product['sale_price'];
        $productObject->code = $product['code'];
        $productObject->brand_id = $product['brand_id'];
        $productObject->is_sale = $product['is_sale'];
        $productObject->image = $product['image'];
        $productObject->brand = $brandTitle;
        $productObject->brand_id = $product['brand_id'];
        $productObject->price = $product['price'];
        $productObject->quantity = $product['quantity'];
        $productObject->attributes = $attributes;
        $productObject->alikeOnes = $productsAlike;

        return $productObject;
    }

    public function getByBrand($brand_id)
    {
        $products = array();
        foreach ($this->db->connection->query("SELECT * FROM " . $this->getTableName() . " WHERE brand_id = $brand_id")->fetchAll() as $product) {
            $brandObject = new Brand();
            $brandTitle = $brandObject->getTitle($product['brand_id']);
            $productAttributesObject = new ProductAttribute();
            $productAttributes = $productAttributesObject->getAttributesIdByProductId($product['id']);
            $attributeObject = new Attribute();
            $attributes = array();
            foreach ($productAttributes as $productAttribute) {
                $attributes[] = $attributeObject->getTitle($productAttribute->attributeId);
            }

            $productObject = new self();
            $productObject->id = $product['id'];
            $productObject->title = $product['title'];
            $productObject->description = $product['description'];
            $productObject->sale_price = $product['sale_price'];
            $productObject->code = $product['code'];
            $productObject->brand_id = $product['brand_id'];
            $productObject->is_sale = $product['is_sale'];
            $productObject->image = $product['image'];
            $productObject->brand = $brandTitle;
            $productObject->price = $product['price'];
            $productObject->quantity = $product['quantity'];
            $productObject->attributes = $attributes;
            $products[] = $productObject;
        }

        return $products;
    }


//    public function getTitleById($id)
//    {
//        $productObject = new self();
//        $productObject->title = $this->db->connection->query("SELECT title FROM products WHERE id = $id")->fetchAll();
//        return $productObject;
//    }

    public function getTableName()
    {
        return 'products';
    }
}