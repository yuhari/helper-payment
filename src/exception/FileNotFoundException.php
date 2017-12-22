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

class FileNotFoundException extends Base {
	
	protected $code = 5001 ;
	
	public static function factory($message) {
		$message .= " not found." ;
		return parent::factory($message) ;
	}
}
