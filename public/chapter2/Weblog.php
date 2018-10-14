<?php
/**
 * Created by PhpStorm.
 * User: imac1
 * Date: 10/14/18
 * Time: 12:37
 */

require_once "Template.php";

class Weblog {
    protected $dbh;

    /**
     * @param mixed $dbh
     */
    public function setDbh($dbh)
    {
        $this->dbh = $dbh;
    }

    public function show_entry($entry_id)
    {
        $query = "SELECT * FROM users WHERE name = :1 ";
        $stmt = $this->dbh->prepare($query)->execute($entry_id);
        $entry = $stmt->fetch_row();
        print_r($entry);
    }
}

class Weblog_Std extends Weblog {
    protected $dbh;
    public function __construct()
    {
        $this->dbh = new DB_Mysql_Test();
    }
}

$blog = new Weblog_Std();
//$blog = new Weblog();
//$blog->setDbh($dbh);
$blog->show_entry("vasya");
