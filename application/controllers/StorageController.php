<?php
namespace application\controllers;

use application\Session;
use application\models\Storage;
use application\exceptions\SessionException;
use application\exceptions\StorageException;

class StorageController
{
    public function get_products()
    {
        try {
            Session::start();
            $products = Storage::get_products();
            if (Session::contains('email')) $usr_email = Session::get('email');
            if ($usr_email) include(ROOT.'/application/views/includes/header_signed.php');
            else include(ROOT.'/application/views/includes/header.php');
            include(ROOT.'/application/views/main/main.php');
            include(ROOT.'/application/views/includes/footer.php');
        } catch (SessionException $e) {
            echo $e->getMessage();
        } catch (StorageException $e) {
            echo $e->getMessage();
        }
    }

    public function get_product_by_id($id)
    {
        try {
            $products = Storage::get_product_by_id($id);
            Session::start();
            $usr_email = Session::get('email');
            if ($usr_email) include(ROOT.'/application/views/includes/header_signed.php');
            else include(ROOT.'/application/views/includes/header.php');
            include(ROOT.'/application/views/main/main.php');
            include(ROOT.'/application/views/includes/footer.php');
        } catch (StorageException $e) {
            echo $e->getMessage();
        } catch (SessionException $e) {
            echo $e->getMessage();
        }
    }
}