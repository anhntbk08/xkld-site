<?php 
	abstract class Ice_Db_Adapter {
		
		public function executeSelect($query, $data) {
			$parsed = $this->parseQuery($query);
			$statement = $this->prepare($parsed->query);
			foreach ($parsed->params as $key=>$p) {
				$statement->bindParam($key+1, $data->$p);
			}
			$statement->execute();
			return $statement;
		}
		
		public function executeUpdate($query, $data) {
			$parsed = $this->parseQuery($query);
			$statement = $this->prepare($parsed->query);
			foreach ($parsed->params as $key=>$p) {
				$statement->bindParam($key+1, $data->$p);
			}
			return $statement->execute();
		}
		
		public function executeInsert($query, $data)  {
			$parsed = $this->parseQuery($query);
			$statement = $this->prepare($parsed->query);
			foreach ($parsed->params as $key=>$p) {
				$statement->bindParam($key+1, $data->$p);
			}

			$result = $statement->execute();
			$key = $data->key;
			$data->$key = $this->getLastInsertId();
			return $result;
		}
		
		public abstract function prepare($obj);
			
		public abstract function load($obj);
		
		public abstract function query($obj, $query);
		
		public abstract function select($obj, $where, $choice, 
				$order, $group, $pageIndex, $pageSize);
		
		public abstract function update($obj, $fields, $where);
		
		public abstract function insert($obj, $fields);
		
		public abstract function delete($obj, $where);
		
		public abstract function setup($host, $port, $dbName, $username, $password);
		
		public abstract function getLastInsertId();
		
		public abstract function getErrorInfo();
		
		protected function parseQuery($query)	{
			$parsedQuery = "";
			$params = array();
			
			$frag = explode(" ", $query);
			foreach($frag as $f)	{
				$f = trim($f);
				if (empty($f))
					continue;
				if ($f{0} == '?')	{
					$params[] = substr($f, 1);
					$f = "?";
				}
				$parsedQuery .= $f . " ";
			}
			
			$obj = new stdClass();
			$obj->query = $parsedQuery;
			$obj->params = $params;
			return $obj;
		}
	}
?>
