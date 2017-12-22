<?php
/**
 * 
 *
 * @author yuhari
 * @version $Id$
 * @copyright , 22 December, 2017
 * @package default
 */

/**
 * 微信网关请求
 */
namespace payment\request ;

class WechatRequest extends Base {
	
	protected $encoding = 'raw' ;
	
	protected $data_format = 'xml' ;
	
	public function send() {
		$response = $this->handler_request->send() ; 
		
		return new \payment\response\WechatResponse($response, $this) ;
	}
}
