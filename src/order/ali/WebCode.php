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
 * web 扫码
 */
namespace payment\order\ali ;

class WebCode extends Base {
	
	protected $qr_paymode = 2 ;
	
	public function __construct($params = array()) {
		parent::__construct($params) ;
		
		$this->qr_pay_mode = $this->qr_paymode ;
	}
}
