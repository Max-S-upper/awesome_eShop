<?php
namespace application\controllers;

//use application\models\Product;
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
//            $products = $productObject->getProducts();
            $products = $productObject->getAll();
//            var_dump($products);

            if (Session::contains('email')) $usr_email = Session::get('email');
            if ($usr_email) include(ROOT.'/application/views/includes/header_signed.php');
            else include(ROOT.'/application/views/includes/header.php');
            include(ROOT.'/application/views/includes/search.php');
            include(ROOT.'/application/views/main/main.php');
            include(ROOT.'/application/views/includes/footer.php');
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
            require_once ROOT.'/application/views/includes/wrapper_product.php';
            if (Session::contains('email')) {
                $usr_email = Session::get('email');
                require_once ROOT.'/application/views/includes/header_signed.php';
            }

            else require_once ROOT.'/application/views/includes/header.php';
            require_once ROOT.'/application/views/includes/search.php';
            require_once ROOT.'/application/views/main/product.php';
            require_once ROOT.'/application/views/includes/footer.php';
        } catch (SessionException $e) {
            echo $e->getMessage();
        }
    }

    public function getProductsByBrand($brand)
    {
        //Unite a brand name with spaces instead of %20 in URI
        $brand_without_spaces = explode('%20', $brand);
        $brand = '';
        foreach ($brand_without_spaces as $brand_part) {
            if ($brand) $brand .= ' ';
            $brand .= $brand_part;
        }

        try {
            Session::start();
            $productObject = new Product();
            $products = $productObject->getByBrand($brand);
            if (Session::contains('email')) $usr_email = Session::get('email');
            if ($usr_email) include(ROOT.'/application/views/includes/header_signed.php');
            else include(ROOT.'/application/views/includes/header.php');
            include(ROOT.'/application/views/includes/search.php');
            include(ROOT.'/application/views/main/main.php');
            include(ROOT.'/application/views/includes/footer.php');
        } catch (SessionException $e) {
            echo $e->getMessage();
        }
    }
}