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
 * file not found
 */
namespace payment\exception ;

class UnknownException extends Base {
	
	protected $code = 5010 ;
	
	public static function factory($message) {
		$message = "unkown error, [" . $message . "]" ;
		return parent::factory($message) ;
	}
}
