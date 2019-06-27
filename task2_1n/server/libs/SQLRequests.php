<?php

abstract class SQLRequests
{
	private $dsn;
	private $user;
	private $pass;

	private $sql;
	private $fields;
	private $tables;
	private $order;
	private $limit;
	private $group;
	private $where;
	private $having;
	private $params;
	private $returning;
	private $queryType;
	private $Errors = array();
	private $results = array();

	public function __construct()
	{
		$this->clear();
	}

	protected abstract function addQuotes($str);
	public function clear()
		{
		$this->sql='';
		$this->fields=array();
		$this->method='';
		$this->tables='';
		$this->order='';
		$this->limit='';
		$this->group='';
		$this->where='';
		$this->having='';
		$this->params=array();
		$this->queryType=0;
		$this->setPart='';
		$this->returning='';
		$this->result=array();

	}

protected function setError($block, $error)
{
	$this->Errors[$block]=$error;
}

public function getErrors()
{
	return $this->Errors;
}

	protected function connect()
	{
		try
		{
			$this->dbh = new PDO($this->getDsn(), $this->getUser(), $this->getPassword());
			if (!$this->dbh)
    	{
       	throw new Exception('Could not connect: ' . mysql_error());
      }
  	}
		catch (Exception $ex)
		{
			$error = $ex->getMessage();
			$this->setError('connet', $error);
		}
	}
	
	public function exec()
	{
		$this->buildQery();
		$stmt = $this->dbh->prepare($this->sql);
		foreach ($this->params as $key=>$val)
		{
			$stmt->bindParam($key, $this->params[$key]);
		}
		$stmresult = $stmt->execute();
		if (false === $stmresult)
		{
			$this->setError('func_exec',SQL_EXECUTION_ERROR);
		}
		else
		{
			if('select_type' === $this->queryType)
			{
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
			else
			{
				$result=$stmresult;
			}
			$stmt->closeCursor();
			$resJSON = json_encode($result);
			$this->clear();
			return $resJSON;
		}
	}

	public function getDsn()
	{
		return $this->dsn;
	}

	public function setDsn($dsn)
	{
		$this->dsn = $dsn;
	}

	public function getUser()
	{
		return $this->user;
	}

	public function setUser($user)
	{
		$this->user = $user;
	}

	public function getPassword()
	{
		return $this->pass;
	}

	public function setPassword($password)
	{
		$this->pass = $password;
	}

	public function getSql()
	{
		return $this->sql;
	}

	public function setParam($params)
	{
		foreach ($params as $key=>$val)
		{
			if ($key=="*" || !(trim($key)) || $val=="*" || !(trim($val)))
			{
				$err=NOT_ACCEPTED_TABLE_ERROR;
				$this->setError('NAME',$err);
			}
			else
			{
				$this->addParam($key,$val);
			}
		}
		return $this;
	}

	public function getParam()
	{
		return $this->params;
	}

	private function addParam($field, $val)
		{
			$paramName = $this->prepareParam($field);
			$this->params[$paramName] = $val;
			return $paramName;
		}

	private function prepareParam($field)
	{
		$param=str_replace(' ','',$field);
		$param=':'.str_replace('.','',$field);
		return $param;
	}

	public function distinct($field)
	{
		$field='DISTINCT'.$this->prepareField($field);
		array_unshift($this->fields, $field);
		return $this;
	}

	public function setField($field)
	{
		if ($field=="*" || !(trim($field)))
		{
			$err=NOT_ACCEPTED_TABLE_ERROR.' '.$field;
			$this->setError('NAME',$err);
		}
		else
		{
			array_push($this->fields, $field);
			return $field;
		}
	}

	private function prepareField($field)
	{
		$rez=$this->addQuotes($field);
		return $rez;
	}

	public function getField()
	{
		return $this->field;
	}

	public function setTable($tableName)
	{
		if (is_array($tableName))
		{
			foreach ($tableName as $name) {
				if ($name=="*" || !(trim($name)))
				{
					$err=NOT_ACCEPTED_TABLE_ERROR.' '.$name;
					$this->setError('NAME',$err);
				}
				else
				{
					$this->addTable($this->prepareTableName($name));
				}
			}
		}
		else
		{
			if ($tableName=="*" || !(trim($tableName)))
				{
					$err=NOT_ACCEPTED_TABLE_ERROR.' '.$where;
					$this->setError('NAME',$err);
				}
				else
				{
					$this->addTable($this->prepareTableName($tableName));
				}
		}
		return $this;
	}

	private function addTable($table,$sign=' ')
	{
		if (strlen($this->tables)!==0)
		{
			$this->tables.=$sign;
		}
		$this->tables.=$table;
	}

	protected function prepareTableName($tableName)
	{
		return $tableName;
	}

	public function join($table, $field1, $field2)
	{
		$join='INNER JOIN '.$this->prepareTableName($table)
		.' ON'.$this->prepareField($field1).'='.$this->prepareField($field2);
		$this->addTable($join,' ');
		return $this;
	}

	public function leftJoin($table, $field1, $field2)
	{
		$join='LEFT OUTER JOIN '.$this->prepareTableName($table)
		.' ON'.$this->prepareField($field1).'='.$this->prepareField($field2);
		$this->addTable($join,' ');
		return $this;

	}

	public function rightJoin($table, $field1, $field2)
	{
		$join='LEFT OUTER JOIN '.$this->prepareTableName($table)
		.' ON'.$this->prepareField($field1).'='.$this->prepareField($field2);
		$this->addTable($join,' ');
		return $this;
	}

	public function crossJoin($table)
	{
		$join='CROSS JOIN '.$this->prepareTableName($table);
		$this->addTable($join,' ');
		return $this;
	}

	public function naturalJoin($table)
	{
		$join='NATURAL JOIN '.$this->prepareTableName($table);
		$this->addTable($join,' ');
		return $this;
	}


	public function order($fields)
	{
		$order='';
		if (0 === strlen($this->order))
		{
			$order=' ORDER BY';
		}

		foreach ($fields as $field)
		{
			if (strpos($field, ' ') !== false)
			{
				$split = preg_split("/[\s]/",$field);
				$order.=' '.$this->prepareField($split[0]).' '.$split[1].',';
			}
			else
			{
				$order.=' '.$this->prepareField($field).',';
			}
		}
		$this->order.=substr($order, 0, -1);
		return $this;
	}



	public function group($fields)
	{
		$group='';
		if (strlen($this->group)===0)
		{
			$group=' GROUP BY';
		}
		foreach ($fields as $field)
	 	{
			$group.=' '.$this->prepareField($field).',';
		}
		$this->group.=substr($group, 0, -1);
		return $this;
	}


	public function limit($minlim,$max=false)
	{
		$this->limit.=' LIMIT '.$minlim;
		if(false !== $maxlim)
		{
			$this->limit.=','.$maxlim;
		}
		return $this;
	}

	public function where($field,$operation,$param,$operand='')
	{
		$where = '';
		if(strlen($this->where)===0)
		{
			$where .=' WHERE';
			$where .=' '.$this->prepareField($field).' '.$operation.' '.$param;
		}
		else
		{
			$where .=' '.$operand.' '.$this->prepareField($field).' '.$operation.' '.$param;
		}
		$this->where.=$where;
		return $this;
	}

	public function having($field,$operation,$param,$operand='')
	{
		$having = '';
		if(strlen($this->having)===0)
		{
			$having .=' HAVING';
			$having .=' '.$this->prepareField($field).' '.$operation.' '.$param;
		}
		else
		{
			$having .=' '.$operand.' '.$this->prepareField($field).' '.$operation.' '.$param;
		}
		$this->having.=$having;
		return $this;
	}

	public function returning()
	{
		$this->returning=' RETURNING '.implode(", ", $this->fields);
		return $this;
	}


	public function MySelect($fields=array())
	{
		$this->queryType='select_type';
		foreach ($fields as $field)
		{
			if ($field=="*" || !(trim($field)))
			{
				$err=NOT_ACCEPTED_TABLE_ERROR;
				$this->setError('SELECT DATA',$err);
			}
			else
			{
				$this->setField($field);
			}
		}
		return $this;
	}

	public function MyInsert($columns)
	{
		$this->queryType='insert_type';
		foreach ($columns as $key=>$val)
		{
			if ($key=="*" || !(trim($key)) || $val=="*" || !(trim($val)))
			{
				$err=NOT_ACCEPTED_TABLE_ERROR;
				$this->setError('INSERT DATA',$err);
			}
			else
			{
				$this->setField($key);
				$this->setParam(array($key=>$val));
			}
		}
		return $this;
	}

	public function MyUpdate($columns)
	{
		$this->queryType='update_type';
		$strFields='';
		foreach ($columns as $key=>$val)
		{
			if ($key=="*" || !(trim($key)) || $val=="*" || !(trim($val)))
			{
				$err=NOT_ACCEPTED_TABLE_ERROR;
				$this->setError('UPDATE DATA',$err);
			}
			else
			{
				$field = $this->setField($key);
				$param = $this->addParam($key,$val);
				$strFields.=' '.$field.'='.$param.',';
			}
		}
		$this->setPart.=substr($strFields, 0, -1);
		return $this;
	}


	public function MyDelete()
	{
		$this->queryType='delete_type';
		return $this;
	}


	public function buildQery()
	{
		switch ($this->queryType) {
		case 'select_type':
			if(count($this->fields<=0))
			{
				$this->setError('buildQery_case1',EMPTY_FIELD_ERROR);
			}

			if(strlen($this->tables)<=0)
			{
				$this->setError('buildQery_case1',EMPTY_TABLE_ERROR);
			}
			$this->makeSelect();
			break;

		case 'insert_type':
			if(count($this->fields)<=0)
			{
				$this->setError('buildQery_case2',EMPTY_FIELD_ERROR);
			}

			if(strlen($this->tables)<=0)
			{
				$this->setError('buildQery_case2',EMPTY_TABLE_ERROR);
			}
			$this->makeInsert();
			break;

		case 'update_type':
			if(count($this->fields)<=0)
			{
				$this->setError('buildQery_case3',EMPTY_FIELD_ERROR);
			}

			if(strlen($this->tables)<=0)
			{
				$this->setError('buildQery_case3',EMPTY_TABLE_ERROR);
			}
			$this->makeUpdate();
			break;

		case 'delete_type':
			if(strlen($this->tables)<=0)
			{
				$this->setError('buildQery_case4',EMPTY_TABLE_ERROR);
			}
			$this->makeDell();
			break;
		}
		return $this;
	}

	public function makeSelect()
	{
		$this->sql='SELECT '.implode(", ",$this->fields).' FROM '.$this->tables;
		if(strlen($this->where)>0)
		{
			$this->sql.=$this->where;
		}
		if (strlen($this->group)>0)
		{
			$this->sql.=$this->group;
			if (strlen($this->having))
			{
				$this->sql.=$this->having;
			}
		}
		if (strlen($this->order))
		{
			$this->sql.=$this->order;
		}

		if (strlen($this->limit))
		{
			$this->sql.=$this->limit;
		}
		return $this;
	}

	public function makeInsert()
	{
		$this->sql=' INSERT INTO '.$this->tables.' ('.implode(" ,", $this->fields).')
		VALUES ('.implode(" ,", array_keys($this->params)).')'.' '.$this->returning;
		return $this;
	}

	public function makeUpdate()
	{
		$this->sql=' UPDATE '.$this->tables.' SET '.$this->setPart.' ';
		if(strlen($this->where)>0)
		{
			$this->sql.=$this->where;
		}
		return $this;
	}

	public function makeDell()
	{
		$this->sql=' DELETE FROM '.$this->tables;
		if(strlen($this->where)>0)
		{
			$this->sql.=$this->where;
		}
		return $this;
	}

}
