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
 * 微信订单
 */
namespace payment\order\wechat ;

class Base extends \payment\order\Base {
	
	protected static $trade_type = '' ;
	
	protected $constrains = array(
		'required' => array(
			'nonce_str' , 'body' , 'out_trade_no' , 'total_fee' , 'spbill_create_ip' ,'trade_type'
		) ,
		'rely' => array(
			'sign_type' => array(
				array('value' => array('HMAC-SHA256', 'MD5'), 'must' => 1)
			) ,
		),
	) ;
	
	public function __construct($action='pay' ,$params = array()) {
		parent::__construct($params) ;
		
		if ($action == 'pay') {
			$this->trade_type = static::$trade_type ;
		}else{
			$this->check_constrains = false ;
		}
	}
	
}
