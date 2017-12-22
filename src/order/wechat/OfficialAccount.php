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
 * 公众号订单
 */
namespace payment\order\wechat ;

class OfficialAccount extends Base {
	
	//公众号，jsapi
	protected static $trade_type = 'JSAPI' ;
	
	protected $constrains = array(
		'rely' => array(
			'trade_type' => array(
				array('value' => 'JSAPI', 'required' => array('openid'))
			),
		),
	) ;
	
	protected function getConstrains() {
		return array_merge_recursive(parent::getConstrains(), $this->constrains) ;
	}
}
