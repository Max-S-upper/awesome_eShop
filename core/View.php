<?php


namespace core;


use application\components\exceptions\RenderException;

class View
{
    protected static $viewPath = '/application/views/main/';

    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = dirname(__DIR__) . self::$viewPath . $view . '.php';

        if (file_exists($file)) {
            require_once $file;
        } else {
            throw new RenderException("File {$view} not found.");
        }
    }
}