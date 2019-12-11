<?php
include_once(ROOT.'/Session.php');
include_once(ROOT.'/application/models/Authorization.php');
class AuthorizationController {
    public function show_authorization_page() {
        if (!Session::sessionExists()) {
            try {
                Session::start();
            } catch (Session_start_exists $e) {
                $start_err = $e->getMessage();
            }
        }

        if (!$start_err) {
            try {
                if (Session::contains('email')) header("Location: /signed");
                else if (Session::contains('login_err')) $err = Session::get('login_err');
            } catch (Session_not_exists_contains $e) {
                $err = $e->getMessage();
            }

            include(ROOT.'/application/views/includes/header.php');
            include(ROOT.'/application/views/main/login.php');
            include(ROOT.'/application/views/includes/footer.php');
        }

        else echo $start_err;
    }

    public function check_authorization() {
        $usr_email = array_key_exists('email', $_POST) ? $_POST['email'] : '';
        $usr_password = array_key_exists('password', $_POST) ? $_POST['password'] : '';

        try {
            if (Authorization::auth($usr_email, $usr_password)) self::show_welcome_page();
        } catch (Account_not_exists $e) {
            $err = $e->getMessage();
        } catch (Wrong_password $e) {
            $err = $e->getMessage();
        }

        if ($err) {
            Session::set('login_err', $err);
            header("Location: /login");
        }
    }

    public function show_welcome_page() {
        if (!Session::sessionExists()) Session::start();
        $usr_email = Session::get('email');
        include(ROOT.'/application/views/includes/header_signed.php');
        include(ROOT.'/application/views/main/successful_authorization.php');
        include(ROOT.'/application/views/includes/footer.php');
    }
}