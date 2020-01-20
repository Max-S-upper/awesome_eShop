<?php


namespace application\controllers;

use application\exceptions\RegistrationException;
use application\exceptions\SessionException;
use application\models\User;
use application\Session;

class RegistrationController
{
    public function showRegistrationPage()
    {
        try {
            if (!Session::sessionExists()) Session::start();
            if (Session::contains('email')) header("Location: /");
            else if (Session::contains('registration_err')) $err = Session::get('registration_err');
        } catch (SessionException $e) {
            $err = $e->getMessage();
        }

        require_once ROOT . '/application/views/includes/head.php';
        require_once ROOT.'/application/views/includes/wrapper.php';
        require_once ROOT . '/application/views/includes/header.php';
        require_once ROOT . '/application/views/includes/signInPopUp.php';
        require_once ROOT.'/application/views/main/signup.php';
        require_once ROOT.'/application/views/includes/footer.php';
    }

    public function createCustomer()
    {
        try {
            $email = $_POST['email'];
            $userController = new UserController();
            $userController->emailExists($email);

            $_POST['surname'] ? $userSurname =  $_POST['surname'] : $userSurname =  '';
            $_POST['email'] ? $userEmail =  $_POST['email'] : $userEmail =  '';
            $_POST['name'] ? $userName =  $_POST['name'] : $userName =  '';
            $_POST['password'] ? $userPassword =  password_hash($_POST['password'], PASSWORD_DEFAULT) : $userPassword =  '';
            $user = new User();
            $user->name = $userName;
            $user->email = $userEmail;
            $user->password = $userPassword;
            $user->surname = $userSurname;
            $user->roleId = 1;
            $user->isBlocked = 0;
            $user->save();
        } catch (RegistrationException $e) {
            if (!Session::sessionExists()) Session::start();
            Session::set('registration_err', $e->getMessage());
            header("Location: /signup");
        }
    }
}