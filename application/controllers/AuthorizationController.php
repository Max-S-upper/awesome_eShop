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

        include(ROOT . '/application/views/includes/head.php');
        include(ROOT.'/application/views/main/login.php');
        include(ROOT.'/application/views/includes/footer.php');
    }

    public function checkAuthorization()
    {
        $user_email = array_key_exists('email', $_POST) ? $_POST['email'] : '';
        $user_password = array_key_exists('password', $_POST) ? $_POST['password'] : '';

        $user = new User();
        $stmt = $user->emailExists($user_email);
        if ($stmt) {
            $userData = $stmt->fetchAll();
            if ($user->isPassword($userData[0]['password'], $user_password)) {
                if (!Session::sessionExists()) Session::start();
                Session::set('email', $user_email);
                $user->id = $userData['id'];
                $user->email = $user_email;
                return 'ok';
            }

            else return 'Wrong password';
        }

        else return "Account with this email doesn't exist";



//        try {
//            $userObject = new User();
//            $user = $userObject->checkUser($user_email, $user_password);
//            return 'ok';
//        } catch (AuthorizationException $e) {
//            return $e->getMessage();
//        }
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