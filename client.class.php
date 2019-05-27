<?php

// json compatibility functions for php4
require_once('json.compat.php');

/**
 * 
 * PHP Socket Cache Client
 * 
 * Implements an Object Cache via PHP Sockets
 * Objects are passed as JSON, and stored to an array
 * 
 * @author gabe@fijiwebdesign.com
 * @copyright http://www.fijiwebdesign.com/
 * @license http://www.opensource.org/licenses/bsd-license.php
 * @version $Id: client.class.php 3 2009-06-25 10:32:07Z bucabay $
 * 
 * Max read is 2082 bytes, so data must be within that limit
 * 
 * @compat PHP4+
 * 
* LICENSE: Redistribution and use in source and binary forms, with or
* without modification, are permitted provided that the following
* conditions are met: Redistributions of source code must retain the
* above copyright notice, this list of conditions and the following
* disclaimer. Redistributions in binary form must reproduce the above
* copyright notice, this list of conditions and the following disclaimer
* in the documentation and/or other materials provided with the
* distribution.
*
* THIS SOFTWARE IS PROVIDED ``AS IS'' AND ANY EXPRESS OR IMPLIED
* WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
* MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN
* NO EVENT SHALL CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
* INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
* BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS
* OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
* ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR
* TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE
* USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH
* DAMAGE.
* 
 */
class Socket_Cache_Client {
	
	function Socket_Cache_Client($domain, $port = 9801) {
		if ($domain && $port) {
			$this->open($domain, $port);
		}
	}
	
	/**
	 * Open Connection to Socket Cache Server
	 * @return Bool
	 * @param $domain String
	 * @param $port Float[optional]
	 * @param $timeout Int[optional]
	 */
	function open($domain, $port = 9801, $timeout = 15) {
		if(($this->socket = fsockopen($domain, (float) $port)) !== false) {
			socket_set_timeout($this->socket, (int) $timeout);
			return true;
		}
		return false;
	}
	
	/**
	 * Set a cache value
	 * @return Bool
	 * @param $name String Index to save Object to
	 * @param $value Object Object Value
	 */
	function set($name, $value) {
		if ($this->_send(array('cmd'=>'set', 'name'=>$name, 'value'=>$value)) == 'ok') {
			return true;
		}
		return false;
	}
	
	/**
	 * Get a cache value
	 * @return Object
	 * @param $name String Object Index
	 */
	function get($name) {
		return $this->_send(array('cmd'=>'get', 'name'=>$name));
	}
	
	/**
	 * Retrieve the whole cache
	 * @return Array Mixed
	 */
	function dump() {
		return $this->_send(array('cmd'=>'dump'));
	}
	
	function _send($obj) {
		$json = json_encode((object) $obj);
		fwrite($this->socket, $json);
		return json_decode(fread($this->socket, 2082));
	}
	
	/**
	 * Close the Socket Cache Client
	 */
	function close() {
		fclose($this->socket);
	}
	
}
