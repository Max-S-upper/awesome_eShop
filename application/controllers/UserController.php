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
                Session::delete('id');
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

    public function isAuthorized()
    {
        try {
            Session::start();
            if (Session::contains('id')) {
                $user = new User();
                echo json_encode([
                    'data' => $user->getById(Session::get('id')),
                    'error' => null
                ]);
            }

            else {
                echo json_encode([
                    'data' => null,
                    'errorMessage' => 'not authorized'
                ]);
            }
        } catch (SessionException $e) {
            echo json_encode([
                'data' => null,
                'errorMessage' => $e->getMessage()
            ]);
        }
    }
}