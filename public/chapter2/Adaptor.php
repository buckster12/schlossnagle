<?php

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
    $this->dbh = mysqli_connect($this->dbhost, $this->user, $this->pass, $this->dbname);
    if(!$this->dbh) {
      throw new Exception("There is issue with server connect: " . $this->dbhost, 1);
    }
  }

  public function execute($query)
  {
    if(!$this->dbh) {
      $this->connect();
    }
    $ret = mysqli_query($this->dbh, $query);
    if(!$ret) {
      throw new \Exception("Error Processing Request", 1);
    }
    else if(!$ret) {
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
    if(!$dbh) {
      throw new \Exception("Error Processing Request #71", 1);
    }
  }

  public function fetch_row()
  {
    if(!$this->result) {
      throw new \Exception("Error Processing Request", 1);
    }
    return mysqli_fetch_row($this->result);
  }

  public function fetch_assoc()
  {
    return mysqli_fetch_assoc($this->result);
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
      $query = str_replace(":$ph", "'".mysqli_real_escape_string($this->dbh, $pv)."'", $query);
    }
    $this->result = mysqli_query($this->dbh, $query);
    if(!$this->result) {
      throw new \Exception("Error Processing Request with query: " . $query, 1);

    }
    return $this;
  }
}
