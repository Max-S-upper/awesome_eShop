<?php
namespace application\models;

use application\Session;
use application\exceptions\AuthorizationException;

class Authorization
{
    public static function auth($email, $password)
    {
        if (!Session::sessionExists()) Session::start();
        if (Session::contains('email')) return true;
        else {
            if (!self::is_email($email)) throw new AuthorizationException("Account with this email doesn't exist");
            else if (!self::is_password($password)) throw new AuthorizationException("Wrong password");
            else {
                Session::set('email', $email);
                return true;
            }
        }
    }

    public static function is_email($email)
    {
        if ($email == self::get_email()) return true;
        else return false;
    }

    public static function is_password($password)
    {
        if ($password == self::get_password()) return true;
        else return false;
    }

    public static function get_email()
    {
        return 'm.s@gmail.com';
    }

    public static function get_password()
    {
        return '123';
    }
}