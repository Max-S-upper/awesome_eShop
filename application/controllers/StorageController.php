<?php
namespace application\controllers;

use application\models\Product;
use application\Session;
use application\models\Storage;
use application\exceptions\SessionException;

class StorageController
{
    public function getProducts()
    {
        try {
            Session::start();
            foreach (Storage::getIds() as $id) {
                $product = new Product();
                $product->getById($id);
                $products[] = $product;
            }

            if (Session::contains('email')) $usr_email = Session::get('email');
            if ($usr_email) include(ROOT.'/application/views/includes/header_signed.php');
            else include(ROOT.'/application/views/includes/header.php');
            include(ROOT.'/application/views/main/main.php');
            include(ROOT.'/application/views/includes/footer.php');
        } catch (SessionException $e) {
            echo $e->getMessage();
        }
    }

    public function getProductById($id)
    {
        try {
            $product = new Product();
            $product->getById($id);
            Session::start();
            if (Session::contains('email')) {
                $usr_email = Session::get('email');
                include(ROOT.'/application/views/includes/header_signed.php');
            }

            else include(ROOT.'/application/views/includes/header.php');
            include(ROOT.'/application/views/main/product.php');
            include(ROOT.'/application/views/includes/footer.php');
        } catch (SessionException $e) {
            echo $e->getMessage();
        }
    }
}