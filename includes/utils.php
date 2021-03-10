<?php
    function generateToken() {
        srand(round(microtime(true) * 1000));
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_';
        $ret = '';
        for ($i = 0; $i < 32; $i++) {
            $ret .= $chars[rand(0,strlen($chars)-1)];
        }
        return $ret;
    }

    class User {
        public function __construct($u, $p, $d) {
            $this->username = $u;
            $this->password = $p;
            $this->description = $d;
        }
    }

    class Class_Post {
        public function __construct($c, $n, $p, $e, $d) {
            $this->code = $c;
            $this->name = $n;
            $this->professor = $p;
            $this->ects = $e;
            $this->description = $d;
        }
    }

    class Log {
        public function __construct($f, $m) {
            $this->f = $f;
            $this->m = $m;
        }
        
        public function __destruct() {
            file_put_contents($this->f, $this->m, FILE_APPEND);
        }
    }
?>