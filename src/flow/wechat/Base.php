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
 * wechat flow base
 */
namespace payment\flow\wechat ;

use payment\request\WechatRequest ;

abstract class Base extends \payment\flow\Base {
	
	//默认为wechat
	protected $mode = 'wechat' ;
	
	public function prepare() {
		parent::prepare() ;
		
		$this->supplyParams() ;
	}
	
	protected function supplyParams() {		
		$this->order->appid = $this->getConfig('appid') ;
		$this->order->mch_id = $this->getConfig('mch_id') ;
	}
	
	protected function execute($action, $arguments){
		if ($notify_url = $this->getConfig($action . '_notify_url')) {
			$this->order->notify_url =  $notify_url ;
		}
		
		$this->order->sign = \payment\util\Common::generateSign(array_merge($this->order->toArray(),array('key' => $this->getConfig('key'))), isset($this->order->sign_type) ? $this->order->sign_type : 'MD5') ;

		$this->url = $this->getConfig($action . '_url') ;
		
		$this->request = new WechatRequest($this, $arguments) ;
		
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
