<?php
namespace application\controllers;

use core\Session;
use application\models\Authorization;
use application\components\exceptions\SessionException;
use application\components\exceptions\AuthorizationException;
use application\models\User;
use PHPUnit\Util\Exception;

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

        include(ROOT . '/application/views/includes/head.php');
        include(ROOT.'/application/views/main/login.php');
        include(ROOT.'/application/views/includes/footer.php');
    }

    public function checkAuthorization()
    {
        $user_email = array_key_exists('email', $_POST) ? $_POST['email'] : '';
        $user_password = array_key_exists('password', $_POST) ? $_POST['password'] : '';

        $user = new User();
        $userData = $user->emailExists($user_email)->fetchAll();
        if ($userData) {
            if ($user->isPassword($userData[0]['password'], $user_password)) {
                if (!Session::sessionExists()) {
                    Session::start();
                }

                Session::set('email', $user_email);
                $user->id = $userData['id'];
                $user->email = $user_email;
                echo 'ok';
            }

            else {
                echo "Wrong password";
            }
        }

        else {
            echo "Account with this email doesn't exist";
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