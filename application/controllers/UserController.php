<?php
namespace application\controllers;

use application\components\exceptions\RegistrationException;
use application\models\User;
use core\Session;
use application\components\exceptions\SessionException;

class UserController
{
    public function logout()
    {
        try {
            Session::start();
        } catch (SessionException $e) {
            $err = $e->getMessage();
        }

        if (!$err) {
            try {
                Session::delete('email');
                Session::delete('login_err');
            } catch (SessionException $e) {
                $err = $e->getMessage();
            }

            if (!$err) header('Location: /');
        }
    }

    public function emailExists($email)
    {
        $user = new User();
        if ($user->emailExists($email)) throw new RegistrationException('Account with this email already exists');
    }
}