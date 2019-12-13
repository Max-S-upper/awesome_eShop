<?php
namespace application\controllers;

use application\Session;
use application\models\Authorization;
use application\exceptions\SessionException;
use application\exceptions\AuthorizationException;

class AuthorizationController
{
    public function show_authorization_page()
    {
        try {
            if (!Session::sessionExists()) Session::start();
            if (Session::contains('email')) header("Location: /signed");
            else if (Session::contains('login_err')) $err = Session::get('login_err');
        } catch (SessionException $e) {
            $err = $e->getMessage();
        }

        include(ROOT.'/application/views/includes/header.php');
        include(ROOT.'/application/views/main/login.php');
        include(ROOT.'/application/views/includes/footer.php');
    }

    public function check_authorization()
    {
        $usr_email = array_key_exists('email', $_POST) ? $_POST['email'] : '';
        $usr_password = array_key_exists('password', $_POST) ? $_POST['password'] : '';

        try {
            if (Authorization::auth($usr_email, $usr_password)) self::show_welcome_page();
        } catch (AuthorizationException $e) {
            Session::set('login_err', $e->getMessage());
            header("Location: /login");
        }
    }

    public function show_welcome_page()
    {
        if (!Session::sessionExists()) Session::start();
        $usr_email = Session::get('email');
        include(ROOT.'/application/views/includes/header_signed.php');
        include(ROOT.'/application/views/main/successful_authorization.php');
        include(ROOT.'/application/views/includes/footer.php');
    }
}