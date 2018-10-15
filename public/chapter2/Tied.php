<?php
/**
 * Created by PhpStorm.
 * User: imac1
 * Date: 10/14/18
 * Time: 21:10
 */

class Tied {
//    private $dbfile;
    private $db;
    private $json;

    public function __construct($file)
    {
        $this->db = $file;
        $data = @file_get_contents($file);
        $this->json = json_decode($data,1);
    }

    public function __destruct() { }

    public function __get($name)
    {
        $data = $this->json[$name];
        if($data) {
            return $data;
        }
        return false;
    }

    public function __set($name, $value)
    {
        $this->json[$name] = $value;
        file_put_contents($this->db, json_encode($this->json));
    }
}

$a = new Tied("tied.json");

if(!$a->counter) {
    $a->counter = 1;
} else {
    $a->counter++;
}

print "эта страница посещалась " . $a->counter . " раз" . PHP_EOL;
