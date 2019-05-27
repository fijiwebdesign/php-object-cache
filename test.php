<?php

set_time_limit(10);

require_once('client.class.php');

$Cache = new Socket_Cache_Client('127.0.0.1', 9803);

$Cache->set('test', 'This is a test');

var_dump($Cache->dump());
