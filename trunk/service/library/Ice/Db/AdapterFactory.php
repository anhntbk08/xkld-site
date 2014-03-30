<?php 

	require_once('PdoMySqlAdapter.php');

	class Ice_Db_AdapterFactory {
		
		private static $adapter;
		
		public static function getAdapter()	{
			return self::$adapter;
		}
	
		public static function setupAdapter($name, $host, $port, $username, $password, $dbName) {
			if (self::$adapter != null)
				return self::$adapter;
			self::$adapter = new $name;
			self::$adapter->setup($host, $port, $dbName, $username, $password);
			return self::$adapter;
		}
	}
?>