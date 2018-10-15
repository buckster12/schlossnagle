<?php
/**
 * Created by PhpStorm.
 * User: imac1
 * Date: 10/14/18
 * Time: 13:20
 */

function DB_Connection_Factory($key)
{
    switch ($key) {
        case 'Test':
            return new DB_Mysql_Test();
        case 'Prod':
            return new DB_Mysql_Prod();
        case 'Weblog':
            return new DB_Pgsql_Weblog();
        case 'Reporting':
            return new DB_Oracle_Reporting();
        default:
            return false;
    }
}

$dbh = DB_Connection_Factory("Reporting");
