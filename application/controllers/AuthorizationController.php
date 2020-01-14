<?php
namespace application\controllers;

use application\Session;
use application\models\Authorization;
use application\exceptions\SessionException;
use application\exceptions\AuthorizationException;
use application\models\User;

class AuthorizationController
{
    public function showAuthorizationPage()
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

    public function checkAuthorization()
    {
        $user_email = array_key_exists('email', $_POST) ? $_POST['email'] : '';
        $user_password = array_key_exists('password', $_POST) ? $_POST['password'] : '';

        try {
//            if (Authorization::auth($usr_email, $usr_password)) self::showWelcomePage();
            $userObject = new User();
            $user = $userObject->checkUser($user_email, $user_password);
        } catch (AuthorizationException $e) {
            Session::set('login_err', $e->getMessage());
            header("Location: /login");
        }
    }

    public function showWelcomePage()
    {
        if (!Session::sessionExists()) Session::start();
        $usr_email = Session::get('email');
        include(ROOT.'/application/views/includes/header_signed.php');
        include(ROOT.'/application/views/main/successful_authorization.php');
        include(ROOT.'/application/views/includes/footer.php');
    }
}