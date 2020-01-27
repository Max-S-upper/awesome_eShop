<?php
namespace application\controllers;

use application\components\Categories;
use application\components\exceptions\RenderException;
use application\components\Filters;
use application\components\exceptions\SearchException;
use application\components\Pagination;
use application\components\ProductsAlike;
use application\models\ProductAlike;
use core\Session;
use application\components\exceptions\SessionException;
use application\models\Product;
use core\View;

class StorageController
{
    protected $productsPerPageQuantity = 4;
    public function getProductsByPage()
    {
        try {
            Session::start();
            $categoryHelper = new Categories();
            $categories = $categoryHelper->getAll();
            $paginationHelper = new Pagination($this->productsPerPageQuantity);
            $pageNum = array_key_exists('page-num', $_POST) ? $_POST['page-num'] : 1;
            $pagination = $paginationHelper->getHtml($pageNum);
            $productObject = new Product();
            $products = $productObject->getByPage($pageNum, $this->productsPerPageQuantity);
            if (Session::contains('email')) $usr_email = Session::get('email');
            View::render('main', [
                'products' => $products,
                'usr_email' => $usr_email,
                'categories' => $categories,
                'pagination' => $pagination]);
        } catch (SessionException $e) {
            echo $e->getMessage();
        } catch (RenderException $e) {
            echo $e->getMessage();
        }
    }

    public function getProductsByIds()
    {
        $ids = $_POST['productsIds'];
        $product = new Product();
        $products = $product->getById($ids);
        echo json_encode($products);
    }

    public function getProductById($id)
    {
        try {
            $productObject = new Product();
            $product = $productObject->getById($id);
            $productsAlikeHelper = new ProductsAlike();
            $productsAlike = $productsAlikeHelper->getHtml($id);
            Session::start();
            if (Session::contains('email')) $usr_email = Session::get('email');
            View::render('product', [
                'product' => $product,
                'usr_email' => $usr_email,
                'productsAlike' => $productsAlike
            ]);
        } catch (SessionException $e) {
            echo $e->getMessage();
        } catch (RenderException $e) {
            echo $e->getMessage();
        }
    }

    public function getProductsByBrand($brand)
    {
        try {
            Session::start();
            $categoryHelper = new Categories();
            $categories = $categoryHelper->getAll();
            $productObject = new Product();
            try {
                $products = $productObject->getByBrand($brand);
            } catch (SearchException $e) {
                $err = $e->getMessage();
            }

            if (Session::contains('email')) $usr_email = Session::get('email');
            View::render('main', [
                'products' => $products,
                'usr_email' => $usr_email,
                'categories' => $categories,
                'err' => $err]);
        } catch (SessionException $e) {
            echo $e->getMessage();
        } catch (RenderException $e) {
            echo $e->getMessage();
        }
    }

    public function getProductsByCategory($categoryId)
    {
        try {
            Session::start();
            $productObject = new Product();
            $categoryHelper = new Categories();
            $categories = $categoryHelper->getAll();
            try {
                $products = $productObject->getByCategory($categoryId);
            } catch (SearchException $e) {
                $err = $e->getMessage();
            }

            if (Session::contains('email')) $usr_email = Session::get('email');
            View::render('main', [
                'products' => $products,
                'usr_email' => $usr_email,
                'categories' => $categories,
                'err' => $err]);
        } catch (SessionException $e) {
            echo $e->getMessage();
        } catch (RenderException $e) {
            echo $e->getMessage();
        }
    }

    public function getProductsBySubCategory($subCategoryId)
    {
        try {
            Session::start();
            $productObject = new Product();
            $categoryHelper = new Categories();
            $categories = $categoryHelper->getAll();
            $filterHelper = new Filters();
            $filters = $filterHelper->getBySubCategory($subCategoryId);
            try {
                $products = $productObject->getBySubCategory($subCategoryId);
            } catch (SearchException $e) {
                $err = $e->getMessage();
            }

            if (Session::contains('email')) $usr_email = Session::get('email');
            View::render('main', [
                'products' => $products,
                'usr_email' => $usr_email,
                'categories' => $categories,
                'filters' => $filters,
                'err' => $err]);
        } catch (SessionException $e) {
            echo $e->getMessage();
        } catch (RenderException $e) {
            echo $e->getMessage();
        }
    }

    public function getProductsByFilters()
    {
        $attributeIds = $_POST['attributeIds'];
        $subCategoryId = $_POST['subCategoryId'];
        $product = new Product();
        $products = $product->getByAttributeAndSubCategory($attributeIds, $subCategoryId);
        if (empty($products)) echo 'not found';
        else echo json_encode($products);
    }

    public function getProductsByTitle()
    {
        try {
            Session::start();
            $categoryHelper = new Categories();
            $categories = $categoryHelper->getAll();
            $productObject = new Product();
            $title = $_POST['search_data'] ? $_POST['search_data'] : '';
            try {
                $products = $productObject->getByTitle($title);
            } catch (SearchException $e) {
                $err = $e->getMessage();
            }

            if (Session::contains('email')) $usr_email = Session::get('email');
            View::render('main', [
                'products' => $products,
                'usr_email' => $usr_email,
                'categories' => $categories,
                'err' => $err]);
        } catch (SessionException $e) {
            echo $e->getMessage();
        } catch (RenderException $e) {
            echo $e->getMessage();
        }
    }
}