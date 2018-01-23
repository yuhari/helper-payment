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
 * 支付宝即时到账
 */
namespace payment\order\ali_old ;

class WebCode extends Base {
	
	protected $stype = 'MD5' ;
	
	protected $pay_mode = 2 ;
	
	public function __construct($action='pay', $params=array()) {
		parent::__construct($action, $params) ;
		
		if ($action == 'pay') {
			$this->payment_type = 1 ;
			$this->sign_type = $this->stype ;
			$this->qr_pay_mode = $this->pay_mode ;
		}
	}
}
