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
 * web code订单
 */
namespace payment\order\wechat ;

class WebCode extends Base {
	
	//web, Native
	protected static $trade_type = 'NATIVE' ;
	
	protected $constrains = array(
		'rely' => array(
			'trade_type' => array(
				array('value' => 'NATIVE', 'required' => array('product_id'))
			),
		),
	) ;
	
	protected function getConstrains() {
		return array_merge_recursive(parent::getConstrains(), $this->constrains) ;
	}
}
