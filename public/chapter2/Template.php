<?php
/**
 * Created by PhpStorm.
 * User: imac1
 * Date: 10/14/18
 * Time: 12:00
 */

require_once 'Adaptor.php';

class DB_Mysql_Test extends DB_Mysql {
    protected $user = "testuser";
    protected $pass = "testpass";
    protected $dbhost = "db";
    protected $dbname = "testdb";
}

class DB_Mysql_Prod extends DB_Mysql {
    protected $user = "produser";
    protected $pass = "prodpass";
    protected $dbhost = "prod.db.example.com";
    protected $dbname = "prod";
}

//define('DB_MYSQL_PROD_USER', 'testuser');
//define('DB_MYSQL_PROD_PASS', 'testpass');
//define('DB_MYSQL_PROD_DBHOST', 'db');
//define('DB_MYSQL_PROD_DBNAME', 'testdb');

$dbh = new DB_Mysql_Test();
//$dbh = new DB_Mysql_Prod();
$stmt = $dbh->execute("SELECT now() ");
print_r($stmt->fetch_row());
