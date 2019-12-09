<?php
include_once(ROOT.'/models/Session.php');
include_once(ROOT.'/exceptions.php');
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
            } catch (Session_not_exists_delete $e) {
                $err = $e->getMessage();
            }

            if (!$err) header('Location: /');
        }
    }
}