<?php 
	require_once('AdapterFactory.php');

	class Ice_Db_Table {
		
		public $key;
		public $table;
		
		protected $adapter;
		
		public function __construct()	{
			$this->setupAdapter();
		}
		
		public function getErrorInfo() {
			return $this->adapter->getErrorInfo();
		}
		
		protected function setupAdapter()	{
			$this->adapter = Ice_Db_AdapterFactory::getAdapter();
		}
		
		public function load() {
			return $this->adapter->load($this);
		}
		
		public function query($query) {
			return $this->adapter->query($this, $query);
		}
		
		public function select($where=null, $choice=null, $order=null, $group=null, $pageIndex=-1, $pageSize=-1) {
			return $this->adapter->select($this, $where, $choice, $order, $group, $pageIndex, $pageSize);
		}
		
		public function update($fields, $where=null) {
			return $this->adapter->update($this, $fields, $where);
		}
		
		public function insert($fields) {;
			return $this->adapter->insert($this, $fields);
		}
		
		public function delete($where=null) {
			return $this->adapter->delete($this, $where);
		}
	}
?>