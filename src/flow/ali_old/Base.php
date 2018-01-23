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
 * ali 旧版本接口，主要是为了完善即时到账接口
 */
namespace payment\flow\ali_old ;

use payment\request\AliOldRequest ;

abstract class Base extends \payment\flow\Base {
	
	protected $mode = 'ali_old' ;
	protected $charset = 'utf-8' ;
		
	public function prepare() {
		
		$this->order->seller_email = $this->getConfig('seller_mail') ; 
		
		parent::prepare() ;
		
		$this->supplyParams() ;
	}
	
	protected function supplyParams() {
		$this->order->partner = $this->getConfig('partner') ;
		$this->order->_input_charset = $this->charset ;
	}
	
	protected function execute($action, $arguments) {
		if ($action == 'pay') {
			$this->order->service = $this->getConfig('service') ;
		}
		
		if ($notify_url = $this->getConfig($action . '_notify_url')) {
			$this->order->notify_url = $notify_url ;
		}
		
		if ($return_url = $this->getConfig($action . '_return_url')) {
			$this->order->return_url = $return_url ;
		}
		
		$this->order->sign = \payment\util\Common::generateSign(array_merge($this->order->toArray(), array('key' => $this->getConfig('key'))), $this->order->sign_type, 'sign,sign_type', '') ;
		
		$this->url = $this->getConfig($action . '_url') ;
		
		$this->request = new AliOldRequest($this, $arguments) ;
		
		$response = $this->request->send() ;
		
		return $response ;
	}
	
	public function toArray() {
		return array(
			'url' => $this->url ,
			'order' => $this->order->toArray() ,
		) ;
	}
}
