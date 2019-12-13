<?php
namespace application\controllers;

use application\Session;
use application\exceptions\SessionException;

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
}