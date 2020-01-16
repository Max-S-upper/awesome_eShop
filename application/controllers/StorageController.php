<?php
namespace application\controllers;

//use application\models\Product;
use application\exceptions\SearchException;
use application\Session;
use application\models\Storage;
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

    public function getProductsByTitle()
    {
        try {
            Session::start();
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