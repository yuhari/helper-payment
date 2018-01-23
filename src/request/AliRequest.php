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
 * 支付宝网关请求
 */
namespace payment\request ;

class AliRequest extends Base {
	
	protected $encoding = 'json' ;
	
	public function send() {
		$response = $this->handler_request->send() ; 
		
		return new \payment\response\WechatResponse($response, $this) ;
	}
}
