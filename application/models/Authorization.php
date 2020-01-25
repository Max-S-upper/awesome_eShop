<?php
namespace application\models;

use core\Session;
use application\components\exceptions\AuthorizationException;

class Authorization
{
    public static function auth($email, $password)
    {
        if (!Session::sessionExists()) Session::start();
        if (Session::contains('email')) return true;
        else {
            if (!self::isEmail($email)) throw new AuthorizationException("Account with this email doesn't exist");
            else if (!self::isPassword($password)) throw new AuthorizationException("Wrong password");
            else {
                Session::set('email', $email);
                return true;
            }
        }
    }

    public static function isEmail($email)
    {
        if ($email == self::getEmail()) return true;
        else return false;
    }

    public static function isPassword($password)
    {
        if ($password == self::getPassword()) return true;
        else return false;
    }

    public static function getEmail()
    {
        return 'm.s@gmail.com';
    }

    public static function getPassword()
    {
        return '123';
    }
}