<?php
include_once(ROOT.'/exceptions.php');
class Authorization {
    public static function check_authorization($usr_email, $usr_password) {
        $email = self::get_email();
        $password = self::get_password();
        if ($usr_email != $email) throw new Account_not_exists("Account with this email doesn't exist");
        else if ($usr_email == $email && $usr_password != $password) throw new Wrong_password("Wrong password");
        else return true;
    }

    public static function get_email() {
        return 'm.s@gmail.com';
    }

    public static function get_password() {
        return '123';
    }
}