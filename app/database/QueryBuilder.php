<?php
/**
 * Class for Databese Queries
 */
class QueryBuilder
{
	protected $pdo;
	
	public function __construct(PDO $pdo)
	{
		$this->pdo=$pdo;
	}

	public function selectAll($table)
	{
		try{
		$statement=$this->pdo->prepare("SELECT * FROM {$table}");
		$statement->execute();
		$results=$statement->fetchAll(PDO::FETCH_OBJ);
		return $results;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
		
	}

	public function insert($table,$parameters)
	{
		$keys=array_keys($parameters);
		try{

			$sql=sprintf("INSERT INTO %s (%s) VALUES (%s)",$table,implode(", ", $keys),":".implode(", :", $keys));

			$statement = $this->pdo->prepare($sql);

			$statement->execute($parameters);

		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
		
	}

	public function lastInsertId()
	{
		return $this->pdo->lastInsertId();
	}

	public function sql($sql)
	{
		try{
		$statement=$this->pdo->prepare($sql);
		$statement->execute();
		$results=$statement->fetchAll(PDO::FETCH_OBJ);
		return $results;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
}
?>