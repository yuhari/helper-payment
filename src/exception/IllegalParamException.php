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

class IllegalParamException extends Base {
	
	protected $code = 5002 ;
	
	public static function factory($message) {
		$message .= " is illegal." ;
		return parent::factory($message) ;
	}
}
