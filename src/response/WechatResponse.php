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
 * wechat response
 */
namespace payment\response ;

class WechatResponse extends Base {
	
	protected $data_format = 'xml' ;
	
	protected $check_response = true ;
	
	//微信需要对结果进行签名验证
	protected function after() {
		$t = $this->content ;
		if (!empty($t['sign'])) {

			$key = $this->request->flow->getConfig('key') ;
			$t['key'] = $key ;

			$sign = \payment\util\Common::generateSign($t, !empty($t['sign_type']) ? $t['sign_type'] : 'MD5') ;
			
			if ($sign !== strtolower($t['sign'])) {
				$this->check_response = false ;
			}
		}
	}
}
