# PHP Object Cache

PHP Object Cache is a Memory Object cache, implemented with PHP Sockets. It runs on PHP4 or PHP5+ and requires your PHP build to have sockets enabled.

There are numerous memory caches available, that definitely will have better performance and implementation:

http://www.danga.com/memcached/
http://www.php.net/manual/en/book.apc.php
http://eaccelerator.net/
http://xcache.lighttpd.net/
However, they are not implemented in pure PHP, they require php extensions, and installing the object cache separately.

PHP Object cache should work even on shared hosting, if your host allows Socket deamons. This is mainly the reason I wrote it, so it can be deployed from within your PHP app without any setup if other memory caches are not available.

## Usage

You can use the command line (CLI) or create the socket server in PHP. 

### Start the PHP Object Cache socket deamon via CLI

`/usr/bin/php -c /path/to/php.ini socket.php`

Or start the socket deamon from within PHP:

`exec('/usr/bin/php -c /path/to/php.ini socket.php > log.txt &');`

The & option makes the process run in the background, so your PHP script can continue on. 

An example for windows is in in `create-socket.php`

### Create a cache server via PHP

```
$Server = new Socket_Cache_Server('127.0.0.1', 9801); 
$Server->listen();
```

Then in your PHP code, import the PHP Object Cache client.

```
// require client class 
require_once('client.class.php');

// create a connection to the server 
$Cache = new Socket_Cache_Client('127.0.0.1', 9803);

// set a value 
$Cache->set('test', 'This is a test');

// retrieve a value 
$test = $Cache->get('test');

// dump all values
$test = $Cache->dump();
```

At the moment this is all you have.

## Notes

PHP Object Cache is implemented as a single deamon process. It does not fork other processes simply because support for forking processes and IPC would require PHP extensions. Therefore it will not efficiently use multi-processors.

PHP Object Cache uses `socket_select()` which uses the `select()` system call. So its efficiency will be dependent on that an how PHP implemented `select()`. This is the only "event notification" available in native PHP at the time of writing this library.

At the moment the Object Cache cannot be distributed across servers. You can run an object cache on a separate machine, but it will be independent of other caches.

If you know of a better alternative or was of implementing those noted please let me know.

## Tests and Benchmarks

* Start the socket server via `php socket.php` then
* You can run the simple tests in `test/` directory via `php test/test.php`. 
