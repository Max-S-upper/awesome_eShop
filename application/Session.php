<?php
namespace application;

use application\exceptions\SessionException;

class Session
{
    private static $name;
    public static function setName($name)
    {
        if (self::sessionExists()) throw new SessionException("Error: Can't set session name. Session already started");
        else {
            self::$name = $name;
            session_name($name);
        }
    }

    public static function getName()
    {
        if (!self::sessionExists()) throw new SessionException("Error: Can't get session name. Session hasn't been started");
        else return session_name();
    }

    public static function getSavePath()
    {
        if (!self::sessionExists()) throw new SessionException("Error: Can't get session save path. Session hasn't been started");
        else return session_save_path();
    }

    public static function contains($key)
    {
        if (!self::sessionExists()) throw new SessionException("Error: Can't get session name. Session hasn't been started");
        else {
            if (array_key_exists($key, $_SESSION)) return true;
            else return false;
        }
    }

    public static function sessionExists()
    {
        if (session_status() == 2) return true;
        else return false;
    }

    public static function cookieExists()
    {
        if (isset($_COOKIE['PHPSESSID'])) return true;
        else return false;
    }

    public static function set($key, $val)
    {
        if (self::sessionExists()) $_SESSION[$key] = $val;
        else throw new SessionException("Error: Can't set session value. Session hasn't been started");
    }

    public static function get($key)
    {
        if (self::sessionExists() && array_key_exists($key, $_SESSION)) return $_SESSION[$key];
        else if (!self::sessionExists()) throw new SessionException("Error: Can't get session value. Session hasn't been started");
    }

    public static function start()
    {
        if (!self::sessionExists()) session_start();
        else throw new SessionException("Error: Can't start session. Session already started");
    }

    public static function delete($key)
    {
        if (self::sessionExists()) unset($_SESSION[$key]);
        else throw new SessionException("Error: Can't start session. Session hasn't been started");
    }
}