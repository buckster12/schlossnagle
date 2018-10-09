<?php
ini_set("display_errors", 1);

class DB_Mysql {
  protected $user;
  protected $pass;
  protected $dbhost;
  protected $dbname;
  protected $dbh;

  function __construct($user, $pass, $dbhost, $dbname) {
    $this->user = $user;
    $this->pass = $pass;
    $this->dbhost = $dbhost;
    $this->dbname = $dbname;
  }

  protected function connect()
  {
    $this->dbh = mysql_connect($this->dbhost, $this->user, $this->pass);
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
  public $result;
  public $binds;
  public $query;
  public $dbh;

  public function __construct($dbh, $query)
  {
    $this->query = $query;
    $this->dbh = $dbh;
    if(!is_resource($dbh)) {
      throw new \Exception("Error Processing Request #71", 1);
    }
  }

  public function fetch_row()
  {
    if(!$this->result) {
      throw new \Exception("Error Processing Request", 1);
    }
    return mysql_fetch_row($this->result);
  }

  public function fetch_assoc()
  {
    return mysql_fetch_assoc($this->result);
  }

  public function fetchall_assoc()
  {
    $retval = [];
    while($row = $this->fetch_assoc()) {
      $retval[] =  $row;
    }
    return $retval;
  }

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
      throw new \Exception("Error Processing Request with query: " . $query, 1);

    }
    return $this;
  }
}

$name = "vasya";
$dbh = new DB_Mysql("testuser", "testpass", "db", "testdb");
$stmt = $dbh->prepare("SELECT * FROM users WHERE name = :1 ");
$stmt->execute($name);

$arr = $stmt->fetchall_assoc();
print_r($arr);
