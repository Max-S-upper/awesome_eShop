<?php
namespace application\controllers;

use application\components\Categories;
use application\exceptions\SearchException;
use application\models\Category;
use application\models\Subcategory;
use application\Session;
use application\exceptions\SessionException;
use application\models\Product;

class StorageController
{
    public function getProducts()
    {
        try {
            Session::start();
            $productObject = new Product();
            $products = $productObject->getAll();
            $categoryHelper = new Categories();
            $categories = $categoryHelper->getAll();
            if (Session::contains('email')) $usr_email = Session::get('email');
            require_once ROOT . '/application/views/includes/head.php';
            require_once ROOT.'/application/views/includes/wrapper.php';
            if ($usr_email) include(ROOT.'/application/views/includes/header_signed.php');
            else require_once ROOT . '/application/views/includes/header.php';
            require_once ROOT . '/application/views/includes/signInPopUp.php';
            require_once ROOT.'/application/views/includes/search.php';
            require_once ROOT.'/application/views/main/main.php';
            require_once ROOT.'/application/views/includes/footer.php';
        } catch (SessionException $e) {
            echo $e->getMessage();
        }
    }

    public function getProductsByIds()
    {
        $ids = $_POST['productsIds'];
        $product = new Product();
        $products = $product->getByIds($ids);
        echo json_encode($products);
    }

    public function getProductById($id)
    {
        try {
            $productObject = new Product();
            $product = $productObject->getById($id);
            Session::start();
            require_once ROOT . '/application/views/includes/head.php';
            require_once ROOT.'/application/views/includes/wrapper_product.php';
            if (Session::contains('email')) {
                $usr_email = Session::get('email');
                require_once ROOT.'/application/views/includes/header_signed.php';
            }

            else require_once ROOT . '/application/views/includes/header.php';
            require_once ROOT . '/application/views/includes/signInPopUp.php';
            require_once ROOT.'/application/views/includes/search.php';
            require_once ROOT.'/application/views/main/product.php';
            require_once ROOT.'/application/views/includes/footer.php';
        } catch (SessionException $e) {
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
            require_once ROOT . '/application/views/includes/head.php';
            require_once ROOT.'/application/views/includes/wrapper.php';
            if ($usr_email) include(ROOT.'/application/views/includes/header_signed.php');
            else require_once ROOT . '/application/views/includes/header.php';
            require_once ROOT . '/application/views/includes/signInPopUp.php';
            require_once ROOT.'/application/views/includes/search.php';
            require_once ROOT.'/application/views/main/main.php';
            require_once ROOT.'/application/views/includes/footer.php';
        } catch (SessionException $e) {
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
            require_once ROOT . '/application/views/includes/head.php';
            require_once ROOT.'/application/views/includes/wrapper.php';
            if ($usr_email) include(ROOT.'/application/views/includes/header_signed.php');
            else require_once ROOT . '/application/views/includes/header.php';
            require_once ROOT . '/application/views/includes/signInPopUp.php';
            require_once ROOT.'/application/views/includes/search.php';
            require_once ROOT.'/application/views/main/main.php';
            require_once ROOT.'/application/views/includes/footer.php';
        } catch (SessionException $e) {
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
            try {
                $products = $productObject->getBySubCategory($subCategoryId);
            } catch (SearchException $e) {
                $err = $e->getMessage();
            }

            if (Session::contains('email')) $usr_email = Session::get('email');
            require_once ROOT . '/application/views/includes/head.php';
            require_once ROOT.'/application/views/includes/wrapper.php';
            if ($usr_email) include(ROOT.'/application/views/includes/header_signed.php');
            else require_once ROOT . '/application/views/includes/header.php';
            require_once ROOT . '/application/views/includes/signInPopUp.php';
            require_once ROOT.'/application/views/includes/search.php';
            require_once ROOT.'/application/views/main/main.php';
            require_once ROOT.'/application/views/includes/footer.php';
        } catch (SessionException $e) {
            echo $e->getMessage();
        }
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
            require_once ROOT . '/application/views/includes/head.php';
            require_once ROOT.'/application/views/includes/wrapper.php';
            if ($usr_email) include(ROOT.'/application/views/includes/header_signed.php');
            else require_once ROOT . '/application/views/includes/header.php';
            require_once ROOT . '/application/views/includes/signInPopUp.php';
            require_once ROOT.'/application/views/includes/search.php';
            require_once ROOT.'/application/views/main/main.php';
            require_once ROOT.'/application/views/includes/footer.php';
        } catch (SessionException $e) {
            echo $e->getMessage();
        }
    }
}