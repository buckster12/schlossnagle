<?php
/**
 * Created by PhpStorm.
 * User: imac1
 * Date: 10/14/18
 * Time: 13:28
 */
/*
class Singleton {
    private static $instance = false;
    public $property;

    private function __construct(){}

    public static function getInstance()
    {
        if(self::$instance === false) {
            self::$instance = new Singleton();
        }
        return self::$instance;
    }
}

$a = Singleton::getInstance();
$b = Singleton::getInstance();
$a->property = "hello world";
print $b->property;*/

// $c = new Singleton(); // it's an error - because we announced __constructor as private


// this implementation of Singleton used inner static array of properties
class Singleton {
    private static $props = array();

    public function __construct(){}

    public function __get($name)
    {
        if(array_key_exists($name, self::$props)) {
            return self::$props[$name];
        }
    }

    public function __set($name, $value)
    {
        self::$props[$name] = $value;
    }
}

$a = new Singleton();
$b = new Singleton();
$a->property = "hello world2";
print $b->property;
