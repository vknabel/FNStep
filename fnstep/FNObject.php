<?PHP
//
//!FNStep
//!FNObject.php
//
//!Created by Valentin Knabel on 23.02.13
//!Copyright © 2013 Valentin Knabel. All rights reserved.
//

namespace FNFoundation;

interface object {
	public static function init();
	public static function super();
	public static function cls();
	public function callMethod($method, $list = NULL /*infinite arguments*/);//is static AND non-static
	public function callMethodWithArray($method, array $array);//is static AND non-static
	public static function callStaticMethod($method, $list = NULL /*infinite arguments*/);
	public static function callStaticMethodWithArray($method, array $array);
	public function isKindOf($type);
	public function isMemberOf($class);
	public function respondsToMethod($method);//is static AND non-static;
	public static function respondsToStaticMethod($method);
	public function description();
	public function __toString();
}

class FNObject implements object {
	
	protected function __construct() {}
	
	final protected static function alloc() {
		return new static();
	} 
	
	public static function init() {
		return static:: alloc();
	}
	
	public function __destruct() {}
	
	public static function super() {
		return parent:: cls();
	}
	
	public static function cls() {
		return get_called_class();
	}
	
	public function callMethod($method, $list = NULL /*infinite arguments*/) {//is static AND non-static
		return call_user_func_array(array(isset($this)?$this:static::cls(), cstring($method)), func_get_args());
	}
	
	public function callMethodWithArray($method, array $array) {//is static AND non-static
		return call_user_func_array(array(isset($this)?$this:static::cls(), cstring($method)), carray($array));
	}
	
	public static function callStaticMethod($method, $list = NULL /*infinite arguments*/) {
		return call_user_func_array(array(static::cls(), cstring($method)), func_get_args());
	}
	public static function callStaticMethodWithArray($method, array $array) {
		return call_user_func_array(array(static::cls(), cstring($method)), carray($array));
	}
	
	public function isKindOf($type) {
		return $this instanceof $type;
	}
	
	public function isMemberOf($class) {
		return $this::cls() == cstring($class);
	}
	
	public function respondsToMethod($method) {//is static AND non-static
		return function_exists(array(isset($this)?$this:static::cls(), cstring($method)));
	}
	
	public static function respondsToStaticMethod($method) {
		return function_exists(array(static::cls(), cstring($method)));
	}
	public function description() {
		return s($this->__toString());
	}
	public function __toString() {
		return '<'.$this::cls().'>';
	}
}
	
?>
						