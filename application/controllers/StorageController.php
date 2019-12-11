<?php
include_once(ROOT.'/application/models/Storage.php');
include_once(ROOT.'/Session.php');
include_once(ROOT.'/exceptions.php');
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
            } catch (Session_get_exists $e) {
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
                } catch (Session_get_exists $e) {
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