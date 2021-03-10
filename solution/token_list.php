<?php
	// @title Helper script for token_spray.py
	// @author William Moody
	// @date 10.03.2021

	// Token generating code from include/utils.php
	function generateToken() {
		
	    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_';
		$ret = '';
		for ($i = 0; $i < 32; $i++) {
			$ret .= $chars[rand(0,strlen($chars)-1)];
		}
		return $ret;
	}

	print_r(generateToken());
?>
