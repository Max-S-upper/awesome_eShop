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
    public function checkAuthorization()
    {
        $user_email = array_key_exists('email', $_POST) ? $_POST['email'] : '';
        $user_password = array_key_exists('password', $_POST) ? $_POST['password'] : '';

        $user = new User();
        $userData = $user->emailExists($user_email);
        if ($userData) {
            if ($user->isPassword($userData['password'], $user_password)) {
                if (!Session::sessionExists()) {
                    Session::start();
                }

                Session::set('email', $user_email);
                Session::set('id', $userData['id']);
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
}