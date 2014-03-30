<?php 

	require_once('Adapter.php');

	class Ice_Db_PdoMySqlAdapter extends Ice_Db_Adapter {
		
		protected $pdo;
		
		public function getErrorInfo() {
			return $this->pdo->errorInfo();
		}
		
		public function load($obj) {
			$query = "SELECT * FROM `".$obj->table."` WHERE `".$obj->key."` = ?".$obj->key;
			$stmt = $this->executeSelect($query, $obj);
			$rs = $stmt->fetchAll(PDO::FETCH_CLASS, get_class($obj));
			return count($rs) >= 1;
		}
		
		public function query($obj, $query) {
			$stmt = $this->executeSelect($query, $obj);
			return $stmt->fetchAll(PDO::FETCH_CLASS, get_class($obj));
		}
	
		public function update($obj, $fields, $where) {
			$fieldArr = explode(",", $fields);
			$builder = "UPDATE `".$obj->table."` SET ";
			foreach($fieldArr as $key=>$f)	{
				$f = trim($f);
				if (!strstr($f, " "))
					$f .= " = ?".$f;
				$builder .= $f;
				if ($key<count($fieldArr)-1)	{
					$builder .= " , ";
				}
			}
			
			if (empty($where))	{
				$where = $obj->key." = ?".$obj->key;
			}
			
			$builder .= " WHERE ".$where;
			return $this->executeUpdate($builder, $obj);
		}
		
		public function select($obj, $where, $choice, 
				$order, $group, $pageIndex, $pageSize) {
			$list = array();
			if (empty($choice)) 
				$choice = "*";
			$query = "SELECT ".$choice." FROM `".$obj->table."`";
			if (!empty($where))
				$query .= " WHERE ".$where;
			if (!empty($group))
				$query .= " GROUP BY ".$group;
			if (!empty($order))
				$query .= " ORDER BY ".$order;
			if ($pageIndex >= 0 && $pageSize > 0)
				$query .= " LIMIT ".($pageIndex*$pageSize).",".$pageSize;
			$stmt = $this->executeSelect($query, $obj);
			return $stmt->fetchAll(PDO::FETCH_CLASS, get_class($obj));
		}
			
		public function insert($obj, $fields) {
	        $f = "(";
	        $v = "( ";
	        $option = explode(",", $fields);
	        foreach($option as $i=>$value){
	        	$value = trim($value);
	            $f .= "`" . $value . "`";
	            $v .= "?" . $value;
	            if($i < (count($option) - 1)){
	                $f .= ",";
	                $v .= " , ";
	            } else{
	                $f .= ")";
	                $v .= " )";
	            }
	        }
			$query = "INSERT INTO `" . $obj->table . "` " . $f . " VALUES " . $v;
			// die($query);
	        return $this->executeInsert($query, $obj);
	    }
		
		public function delete($obj, $where) {
			if (empty($where))	{
				$where = $obj->key . " = ?".$obj->key;
			}
	        return $this->executeUpdate("DELETE FROM `" . $obj->table . "` WHERE " . $where, $obj);
	    }
		
		public function setup($host, $port, $dbName, $username, $password) {
			$this->pdo = new PDO('mysql:dbname='.$dbName.';host='.$host.';port='.$port.';charset=utf8', 
					$username, $password,
					array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		}
		
		public function prepare($query) {
			return $this->pdo->prepare($query);
		}
		
		public function getLastInsertId() {
			return $this->pdo->lastInsertId();
		}
	}
?>