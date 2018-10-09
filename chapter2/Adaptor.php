<?php

class DB_Mysql {
  protected $user;
  protected $pass;
  protected $dbhost;
  protected $dbname;
  protected $dbh;

  protected function __construct($user, $pass, $dbhost, $dbname) {
    $this->user = $user;
    $this->pass = $pass;
    $this->dbhost = $dbhost;
    $this->dbname = $dbname;
  }

  protected function connect()
  {
    $this->dbh = mysql_pconnect($this->dbhost, $this->user, $this->pass);
    if(!is_resource($this->dbh)) {
      throw new Exception("Error Processing Request #21", 1);
    }
    if(!mysql_select_db($this->dbname, $this->dbh)) {
      throw new \Exception("Error Processing Request #24", 1);
    }
  }

  public function execute($query)
  {
    if(!$this->dbh) {
      $this->connect();
    }
    $ret = mysql_query($query, $this->dbh);
    if(!$ret) {
      throw new \Exception("Error Processing Request", 1);
    }
    else if(!is_resource($ret)) {
      return true;
    } else {
      $stmt = new DB_MysqlStatement($this->dbh, $query);
      $stmt->result = $ret;
      return $stmt;
    }
  }

  public function prepare($query)
  {
    if(!$this->dbh) {
      $this->connect();
    }
    return new DB_MysqlStatement($this->dbh, $query);
  }
}


class DB_MysqlStatement
{
  public function execute()
  {
    $binds = func_get_args();
    foreach ($binds as $index => $name) {
      $this->binds[$index + 1] = $name;
    }
    $cnt = count($binds);
    $query = $this->query;
    foreach ($this->binds as $ph => $pv) {
      $query = str_replace(":$ph", "'".mysql_escape_string($pv)."'", $query);
    }
    $this->result = mysql_query($query, $this->dbh);
    if(!$this->result) {
      throw new MysqlException;
    }
    return $this;
  }
}


$dbh = new DB_Mysql("testuser", "testpass", "localhost", "testdb");
$stmt = $dbh->prepare("SELECT * FROM users WHERE name = :1 ");
$stmt->execute($name);
?>
