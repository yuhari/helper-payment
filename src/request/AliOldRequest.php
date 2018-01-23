<?php
/**
 * 
 *
 * @author yuhari
 * @version $Id$
 * @copyright , 23 January, 2018
 * @package default
 */

/**
 * 即时到账 旧版 请求
 */
namespace payment\request ;

class AliOldRequest extends Base {
	
	protected $method = 'get' ;
	
	public function send() {
		$request_url = $this->handler_request->getUrl() ; 
		
		return array('request_url' => $request_url) ;
	}
}
