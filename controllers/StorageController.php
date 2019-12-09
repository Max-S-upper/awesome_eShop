<?php
include_once(ROOT.'/models/Storage.php');
include_once(ROOT.'/models/Session.php');
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
                $usr_email = Session::get('email');
            } catch (Session_get_exists $e) {
                $err = $e->getMessage();
            }

            if (!$err) {
                if ($usr_email) include(ROOT.'/views/includes/header_signed.php');
                else include(ROOT.'/views/includes/header.php');
                include(ROOT.'/views/main/main.php');
                include(ROOT.'/views/includes/footer.php');
            }

            else echo $err;
        }
    }

    public function get_product_by_id($id) {
        try {
            $products = Storage::get_product_by_id($id);
        } catch (Product_id_not_exists $e) {
            echo $e->getMessage();
        }

        include(ROOT.'/views/includes/header.php');
        include(ROOT.'/views/main/main.php');
        include(ROOT.'/views/includes/footer.php');
    }
}