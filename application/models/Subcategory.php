<?php


namespace application\models;


class Subcategory extends ActiveRecordEntity
{
    public $id;
    public $title;
    public $category_id;

    public function getByCategoryId($categoryId)
    {
        $subCategories = array();
        foreach ($this->db->connection->query("SELECT * FROM subcategories WHERE category_id = $categoryId")->fetchAll() as $subCategoryData) {
            $subCategory = new self();
            $subCategory->id = $subCategoryData['id'];
            $subCategory->title = $subCategoryData['title'];
            $subCategory->category_id = $subCategoryData['category_id'];
            $subCategories[] = $subCategory;
        }

        return $subCategories;
    }

    public function getTableName()
    {
        return 'subcategories';
    }
}