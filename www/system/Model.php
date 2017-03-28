<?php

/**
 * Created by Ana Zalozna
 * Date: 22/01/17
 * Time: 2:27 PM
 */
abstract class Model
{
	/**
	 * PDO object
	 */
	protected $_pdo;

	/**
	 * Model constructor.
	 *
	 * set PDO
	 */
	function __construct(){
		if(Config::get('db')){
            $dsn = 'mysql:host='.Config::get('db')['host'].';dbname='.Config::get('db')['database'].';charset=utf8';
		}else{
			$dsn = 'mysql:host='.getenv('DB_HOST').';dbname='.getenv('DB_NAME').';charset=utf8';

		}
		$opt = array(
			PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC,
			//PDO::MYSQL_ATTR_INIT_COMMAND    =>"SET time_zone = 'America/Toronto'",
		);

		if(Config::get('db')){
			$this->_pdo = new PDO($dsn, Config::get('db')['user'],Config::get('db')['pass'], $opt);
		}else{
			$this->_pdo = new PDO($dsn, getenv('DB_USER'),getenv('DB_PASS'), $opt);
		}
	}

	/**
	 * Do PDO query and return one row
	 *
	 * @param string $sql
	 * @param array $data
	 * @return mixed
	 */
	protected function queryRow(string $sql, array $data = []){
		$stmt = $this->_pdo->prepare($sql);
		$stmt->execute($data);
		$result = $stmt->fetch();

		if(!$result){
			return [];
		}

		return $result;
	}

	/**
	 * Do PDO query and return rows
	 *
	 * @param string $sql
	 * @param array $data
	 * @return array
	 */
	protected function queryRows(string $sql, array $data = []): array {
		$stmt = $this->_pdo->prepare($sql);
		$stmt->execute($data);

		$data = [];
		foreach ($stmt as $row){
			$data[] = $row;
		}
		return $data;
	}

	/**
	 * Simple insert to db
	 *
	 * Preparing and executing query with data
	 * Array must be with right keys
	 *
	 * @param string $table
	 * @param array $data
	 */
	protected function insertRow(string $table, array $data){
		$columns = '';
		$values = '';

		foreach ($data as $key => $value){
			$columns .= $key.', ';
			$values .= '?, ';
		}

		$sql = "INSERT INTO $table (" .trim($columns, ', '). ")VALUES(" .trim($values, ', '). ")";
		$stmt = $this->_pdo->prepare($sql);
		$stmt->execute(array_values($data));
	}

	/**
	 * Delete one row by id
	 *
	 * @param int $id
	 * @param string $table
	 */
	protected function deleteById(int $id, string $table){
		$stmt = $this->_pdo->prepare("DELETE FROM $table WHERE id = :id");
		$stmt->execute(['id' => $id]);
	}
}