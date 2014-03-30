<?php
class Utils {
	
	public static function generateToken() {
		return uniqid(sha1(rand()), true);
	}
} 