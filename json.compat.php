<?php

/**
 * json_encode and json_decode for PHP4 using json pear library
 * @author gabe@fijiwebdesign.com
 * @license  http://www.opensource.org/licenses/bsd-license.php
 * @copyright http://www.fijiwebdesign.com/
 * @version $Id: json.compat.php 4 2009-06-29 11:51:02Z bucabay $
 * 
 * JSON is just a namespace to hold our Services_JSON singleton
 * 
 */
class JSON {

	/**
	 * Returns the JSON Singleton
	 * @return Object Services_JSON Instance
	 */
	function &_getJSONSingleton() {
		/**
		 * @var static Services_JSON Singleton
		 */
		static $JSON_lib;
	
		if (!isset($JSON_lib)) {
			if (!class_exists('Services_JSON')) {
				require_once('libs/json.pear.php');
			}
			$JSON_lib = new Services_JSON();
		}
		return $JSON_lib;
	}
	
}

/**
 * Allow you to use json_encode() in PHP4
 * @return String
 * @param $obj Object
 * @param $options Int[optional] Bitmask consisting of JSON_HEX_QUOT, JSON_HEX_TAG, JSON_HEX_AMP, JSON_HEX_APOS, JSON_FORCE_OBJECT.
 * Only JSON_FORCE_OBJECT is implemented in PHP4 - not tested
 */
if (!function_exists('json_encode')) {
	function json_encode($obj, $options = 0) {
		$JSON =& JSON::_getJSONSingleton();
		$JSON->use = $options & JSON_FORCE_OBJECT ? 0 : SERVICES_JSON_LOOSE_TYPE;
		$str = $JSON->encode($object);
		return $str;
	}
}

/**
 * Allow you to use json_decode() in PHP4
 * @return Object
 * @param $str String
 * @param $assoc Bool[optional] Convert Objects to Associative Arrays
 */
if (!function_exists('json_decode')) {
	function json_decode($str, $assoc = false) {
		$JSON =& JSON::_getJSONSingleton();
		$JSON->use = $assoc ? SERVICES_JSON_LOOSE_TYPE : 0;
		$obj = $JSON->decode($str);
		return $obj;
	}
}

?>