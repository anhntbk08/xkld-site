<?php

require_once('Ice/Db/AdapterFactory.php');
require_once('configs/PerspectiveConfig.php');

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
	
    public function run() {
    	$this->setupDb();        
        parent::run();
    }
	
	
    public function setupDb() {
        Ice_Db_AdapterFactory::setupAdapter(DbConfig::$adapter, DbConfig::$host, DbConfig::$port, DbConfig::$username, DbConfig::$password, DbConfig::$dbName);
    }
}

?>