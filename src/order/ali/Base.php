<?php
/**
 * 
 *
 * @author yuhari
 * @version $Id$
 * @copyright , 2 January, 2018
 * @package default
 */

/**
 * 支付宝订单
 */
namespace payment\order\ali ;

class Base extends \payment\order\Base {
	
	protected $product_code = 'FAST_INSTANT_TRADE_PAY' ;
	
	protected $constrains = array(
		'required' => array(
			'out_trade_no', 'product_code', 'total_amount', 'subject' 
		)
	) ;
	
	public function __construct($action='pay', $params = array()) {
		parent::__construct($params) ;
		
		if ($action == 'pay') {
			$this->product_code = static::$product_code ;
		}else{
			$this->check_constrains = false ;
		}
	}
}
