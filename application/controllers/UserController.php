<?php
namespace application\controllers;
//include_once(ROOT.'/exceptions.php');
use application\Session;
use application\Session_start_exists;
use application\Session_not_exists_delete;
class UserController {
    public function logout() {
        try {
            Session::start();
        } catch (Session_start_exists $e) {
            $err = $e->getMessage();
        }

        if (!$err) {
            try {
                Session::delete('email');
                Session::delete('login_err');
            } catch (Session_not_exists_delete $e) {
                $err = $e->getMessage();
            }

            if (!$err) header('Location: /');
        }
    }
}