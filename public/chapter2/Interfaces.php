<?php
/**
 * Created by PhpStorm.
 * User: imac1
 * Date: 10/14/18
 * Time: 13:11
 */

interface DB_Connection {
    public function execute($query);
    public function prepare($query);
}

class DB_Mysql implements DB_Connection {
    public function execute($query)
    {
        // TODO: Implement execute() method.
    }

    public function prepare($query)
    {
        // TODO: Implement prepare() method.
    }
}

// ----------
/*
interface A {
    public function abba();
}

interface B {
    public function bar();
}

class C implements A, B {
    public function abba()
    {
        // TODO: Implement abba() method.
    }

    public function bar()
    {
        // TODO: Implement bar() method.
    }
}*/

// ----------

abstract class A {
    public function abba()
    {
        // abba
    }
    abstract public function bar();
}

class B extends A {
    public function bar()
    {
        // TODO: Implement bar() method.
    }
}

$b = new B; // B now has both functions: abba() and bar()

//function addDB(DB_Connection $dbh) {
//    $this->dbh = $dbh;
//}
