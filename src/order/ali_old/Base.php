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
namespace payment\order\ali_old ;

class Base extends \payment\order\Base {
		
	protected $constrains = array(
		'required' => array(
			'out_trade_no', 'subject', 'total_fee', array('seller_id', 'seller_email', 'seller_account_name'),
		),
		'rely' => array(
			'sign_type' => array(
				array('value' => array('DSA', 'RSA', 'MD5'), 'must' => 1)
			) ,
		),
	) ;
	
	public function __construct($action='pay', $params = array()) {
		parent::__construct($params) ;
		
		if ($action != 'pay') {
			$this->check_constrains = false ;
		}
	}
}
