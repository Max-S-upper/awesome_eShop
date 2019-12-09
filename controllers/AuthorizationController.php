<?php
include_once(ROOT.'/models/Session.php');
include_once(ROOT.'/models/Authorization.php');
class AuthorizationController {
    public function show_authorization_page() {
        try {
            Session::start();
        } catch (Session_start_exists $e) {
            $err = $e->getMessage();
        }

        if (!$err) {
            try {
                if (Session::contains('email')) header("Location: /");
            } catch (Session_not_exists_contains $e) {
                $err = $e->getMessage();
            }

            include(ROOT.'/views/includes/header.php');
            include(ROOT.'/views/main/login.php');
            include(ROOT.'/views/includes/footer.php');
        }
    }

    public function check_authorization() {
        $usr_email = $_POST['email'];
        $usr_password = $_POST['password'];
        try {
            if (Authorization::check_authorization($usr_email, $usr_password)) {
                try {
                    Session::start();
                } catch (Session_start_exists $e) {
                    $err = $e->getMessage();
                }

                if (!$err) {
                    Session::set('email', $usr_email);
                    include(ROOT.'/views/includes/header_signed.php');
                    include(ROOT . '/views/main/successful_authorization.php');
                    $successful_authorization = 1;
                }

                else include(ROOT.'/views/includes/header.php');
            }
        } catch (Account_not_exists $e) {
            $err = $e->getMessage();
        } catch (Wrong_password $e) {
            $err = $e->getMessage();
        }

        if (!$successful_authorization) {
            include(ROOT.'/views/includes/header.php');
            include(ROOT.'/views/main/login.php');
        }
        include(ROOT.'/views/includes/footer.php');
    }
}