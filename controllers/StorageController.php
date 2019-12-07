<?php
include_once(ROOT.'/models/Storage.php');
class StorageController {
    public function get_products() {
        $products = Storage::get_products();
        include(ROOT.'/views/includes/header.php');
        include(ROOT.'/views/main/main.php');
        include(ROOT.'/views/includes/footer.php');
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