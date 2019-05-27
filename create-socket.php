<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$exe = 'php';
$args = '-c C:\wamp\bin\apache\Apache2.2.10\bin\php.ini socket.php';

exec_background($exe, $args);

function exec_background($exe, $args = '') {
    if (substr(php_uname(), 0, 7) == "Windows") { 
        pclose(popen("start \"bla\" \"" . $exe . "\" " . $args, "r"));    
    } else { 
        exec($exe . " " . $args . " > /dev/null &");    
    }
} 

echo date(DATE_ATOM);

?>