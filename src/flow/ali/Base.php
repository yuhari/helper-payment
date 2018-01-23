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
 * ali flow base
 */
namespace payment\flow\ali ;

use payment\request\AliRequest ;

abstract class Base extends \payment\flow\Base {
	
	protected $mode = 'ali' ;
	
	protected $charset = 'utf-8' ;
	protected $version = '1.0' ;
	
	public function prepare() {
		parent::prepare() ;
		
		$this->supplyParams() ;
	}
	
	protected function supplyParams() {
		$content = $this->order->toArray() ;
		$this->order->reset() ;
		
		$this->order->app_id = $this->getConfig('app_id') ;
		$this->order->charset = $this->charset ;
		$this->order->version = $this->version ;
		
		$this->order->timestamp = date('Y-m-d H:i:s') ;
		$this->order->biz_content = json_encode($content) ;
	}
	
	protected function execute($action, $arguments) {
		$this->order->method = $this->getConfig($action . '_method') ;
		$this->order->return_url = $this->getConfig($action . '_return_url') ;
		$this->order->notify_url = $this->getConfig($action . '_notify_url') ;
		
		$this->order->sign_type = in_array($this->order->sign_type, array('RSA','RSA2')) ? $this->order->sign_type : 'RSA2' ;
		
		$this->order->sign = \payment\util\Common::generateSign(array_merge($this->order->toArray(), array( 'key'=>$this->getConfig('key'))), $this->order->sign_type) ;
		
		$this->url = $this->getConfig($action . '_url') ;
		
		$this->request = new AliRequest($this, $arguments) ;
		
		$response = $this->request->send() ;
		
		return $response ;
	}
}
