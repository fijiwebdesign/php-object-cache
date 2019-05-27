<?php

set_time_limit(0); // run infinitely

require_once('socket.class.php');

$Server = new Socket_Cache_Server('127.0.0.1', 9801);

$Server->listen();


?>