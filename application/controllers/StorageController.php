<?php
namespace application\controllers;
//include_once(ROOT.'/application/models/Storage.php');
//include_once(ROOT.'/Session.php');
use application\Session;
//include_once(ROOT.'/exceptions.php');
use application\Session_start_exists;
use application\Session_not_exists_get;
use application\Product_id_not_exists;
//include_once(ROOT.'/application/models/Storage.php');
use application\models\Storage;
class StorageController {
    public function get_products() {
        try {
            Session::start();
        } catch (Session_start_exists $e) {
            $err = $e->getMessage();
        }

        if (!$err) {
            try {
                $products = Storage::get_products();
                if (Session::contains('email')) $usr_email = Session::get('email');
            } catch (Product_id_not_exists $e) {
                $err = $e->getMessage();
            }

            if (!$err) {
                if ($usr_email) include(ROOT.'/application/views/includes/header_signed.php');
                else include(ROOT.'/application/views/includes/header.php');
                include(ROOT.'/application/views/main/main.php');
                include(ROOT.'/application/views/includes/footer.php');
            }

            else echo $err;
        }
    }

    public function get_product_by_id($id) {
        try {
            $products = Storage::get_product_by_id($id);
            try {
                Session::start();
            } catch (Session_start_exists $e) {
                $err = $e->getMessage();
            }

            if (!$err) {
                try {
                    $usr_email = Session::get('email');
                } catch (Session_not_exists_get $e) {
                    $err = $e->getMessage();
                }
            }
        } catch (Product_id_not_exists $e) {
            $err = $e->getMessage();
        }

        if (!$err) {
            if ($usr_email) include(ROOT.'/application/views/includes/header_signed.php');
            else include(ROOT.'/application/views/includes/header.php');
            include(ROOT.'/application/views/main/main.php');
            include(ROOT.'/application/views/includes/footer.php');
        }

        else echo $err;
    }
}