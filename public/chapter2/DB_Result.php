<?php
/**
 * Created by PhpStorm.
 * User: imac1
 * Date: 10/14/18
 * Time: 13:53
 */

require_once "Factory.php";

class DB_Result {

    protected $stmt;
    protected $result = [];

    private $rowIndex = 0;
    private $currIndex = 0;
    private $done = false;

    public function __construct(DB_Statement $stmt)
    {
        $this->stmt = $stmt;
    }

    public function first()
    {
        if(!$this->result) {
            $this->result[$this->rowIndex++] = $this->stmt->fetch_assoc();
        }
        $this->currIndex = 0;
        return $this;
    }

    public function last()
    {
        if(!$this->done) {
            array_push($this->result, $this->stmt->fetchall_assoc());
        }
        $this->done = true;
        $this->currIndex = $this->rowIndex = count($this->result) - 1;
    }

    public function next()
    {
        if($this->done) {
            return false;
        }
        $offset = $this->currIndex + 1;
        if(!$this->result[$offset]) {
            $row = $this->stmt->fetch_assoc();
            if(!$row) {
                $this->done = true;
                return false;
            }
            $this->result[$offset] = $row;
            ++$this->rowIndex;
            ++$this->currIndex;
            return $this;
        } else {
            ++$this->currIndex;
            return $this;
        }
    }

    public function prev()
    {
        if($this->currIndex == 0) {
            return false;
        }
        --$this->currIndex;
        return $this;
    }

    public function __get($name)
    {
        if(array_key_exists($name, $this->result[$this->currIndex])) {
            return $this->result[$this->currIndex][$name];
        }
    }
}

