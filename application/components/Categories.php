<?php


namespace application\components;


use config\Db;

class Categories
{
    protected $db;
    public $id;
    public $title;
    public $subCategoryId;
    public $subCategoryTitle;

    public function __construct()
    {
        $this->db = new Db;
    }

    public function getAll()
    {
        $categoriesData = $this->db->connection->query("select categories.*, subcategories.id, subcategories.title from categories left join subcategories on subcategories.category_id = categories.id order by categories.id")->fetchAll();
        $categories = array();
        foreach ($categoriesData as $categoryData) {
            $category = new self();
            $category->id = $categoryData[0];
            $category->title = $categoryData[1];
            $category->subCategoryId = $categoryData[2];
            $category->subCategoryTitle = $categoryData[3];
            $categories[] = $category;
        }

        $categoriesHtml = '<div class="categories">';
        $currentCategory = '';
        foreach ($categories as $category) {
            if ($category->title !== $currentCategory) {
                if (!$currentCategory) {
                    $categoriesHtml .= "<div class='category-container'>
                                            <a href='http://eshop.com/category/$category->id' class='category'>$category->title</a>
                                            <div class='subCategories'>";
                }

                else {
                    $categoriesHtml .= "        </div>
                                            </div>
                                        <div class='category-container'>
                                    <a href='http://eshop.com/category/$category->id' class='category'>$category->title</a>
                                    <div class='subCategories'>";
                }
            }

            $categoriesHtml .= "<a href='http://eshop.com/subCategory/$category->subCategoryId' class='sub-category'>$category->subCategoryTitle</a>";
            $currentCategory = $category->title;
        }

        $categoriesHtml .= "        </div>
                                </div>
                            </div>";
        return $categoriesHtml;
    }
}