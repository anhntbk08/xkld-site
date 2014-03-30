<?php
	class Gadget{
	       // get Date in libary Zend
	         public static function getCurrentTime(){
	                $curTime = Zend_Date::now();
	                $curTime -> setTimezone('Asia/Bangkok'); 
	                return $curTime;
	        }
	        public static function getUniqueID(){
	        	    $date = new DateTime();
	        	    return  $date->getTimestamp();
	        }
	        public static function getCurrentIP(){
	        	$headers = apache_request_headers();
				$curIP = $headers['X-Real-IP'];
	            //$curIP = $_SERVER["REMOTE_ADDR"] ; // $_SERVER['SERVER_ADDR'];
	            return $curIP;
	        }
	}
?>