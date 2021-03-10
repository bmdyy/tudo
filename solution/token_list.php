<?php
	// @title Helper script for token_spray.py
	// @author William Moody
	// @date 10.03.2021

	// Token generating code from include/utils.php
	function generateToken($seed) {
		srand($seed);
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_';
		$ret = '';
		for ($i = 0; $i < 32; $i++) {
			$ret .= $chars[rand(0,strlen($chars)-1)];
		}
		return $ret;
	}

	$t_start = $argv[1];
	$t_end   = $argv[2];

	for ($i = $t_start; $i < $t_end; $i++) {
		print_r(generateToken($i) . "\n");
	}
?>
