<?php
include_once 'SQLRequests.php';

class MysqlRequests extends SQLRequests
{
  function __construct()
  {
    parent::__construct();
    $this->setDsn(MY_DSN);
    $this->setUser(DB_USER);
    $this->setPassword(DB_PASSWORD);
    $this->connect();
  }

  protected function addQuotes($str)
  {
    return '`'.$str.'`';
	}

  protected function prepareTableName($table)
  {
  	return $this->addQuotes($table);
  }
}
