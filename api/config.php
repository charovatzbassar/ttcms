<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ (E_NOTICE | E_DEPRECATED));

class Config {
    public static function DB_NAME() {
        return Config::get_env("DB_NAME", "ttcms");
    }
    public static function DB_PORT() {
        return Config::get_env("DB_PORT", 3306);
    }
    public static function DB_USER() {
        return Config::get_env("DB_USER", 'root');
    }
    public static function DB_PASSWORD() {
        return Config::get_env("DB_PASSWORD", 'Paradigma1230!');
    }
    public static function DB_HOST() {
        return Config::get_env("DB_HOST", 'localhost');
    }
    public static function JWT_SECRET() {
        return Config::get_env("JWT_SECRET", '26941060bbd7851c69563b3e325a240e8c145f3368fae88eb2ed5701b8b9c1fc');
    }
    public static function get_env($name, $default){
        return isset($_ENV[$name]) && trim($_ENV[$name]) != "" ? $_ENV[$name] : $default;
    }
}

?>