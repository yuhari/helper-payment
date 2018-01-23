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
 * ali response
 */
namespace payment\response ;

class AliResponse extends Base {
	
	protected $data_format = 'json' ;
	
	protected $check_response = true ;
	
	//微信需要对结果进行签名验证
	protected function after() {
		$t = $this->content ;
		if (!empty($t['sign'])) {

			$key = $this->request->flow->getConfig('key') ;
			$t['key'] = $key ;

			$sign = \payment\util\Common::generateSign($t, !empty($t['sign_type']) ? $t['sign_type'] : 'RSA2','sign,sign_type', '') ;
			
			if ($sign !== strtolower($t['sign'])) {
				$this->check_response = false ;
			}
		}
	}
}
