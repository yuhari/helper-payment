<?php
/**
 * 
 *
 * @author yuhari
 * @version $Id$
 * @copyright , 21 December, 2017
 * @package default
 */

/**
 * exception base
 */
namespace payment\exception ;

abstract class Base extends \Exception {
	
	public function __toString() {
		$string = sprintf("[%s] %s[Code:%s] %s in file (%s) at line %s.\n", date('Y-m-d H:i:s') , get_class($this), $this->code, $this->message, $this->file, $this->line) ;
		
		return $string ;
	}
	
	//简化的错误生成
	public static function factory($message) {
		$e = new static($message) ;
		return $e ;
	}
}
