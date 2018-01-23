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
 * api 请求
 */
namespace payment\request ;

use anlutro\cURL\cURL ;

use payment\exception\IllegalParamException ;

abstract class Base {
	
	public $flow ;
	
	protected $options = array() ;
	
	protected $handler ; // curl 句柄
	protected $handler_request ; // request
	
	protected $encoding = 'query' ; // query , json , raw
	public static $encoding_table = array('query' => 0, 'json' => 1, 'raw' => 2) ;
	
	protected $method = 'post' ; // get, post
	
	protected $data_format = '' ; // default || xml
	
	public function __construct(\payment\flow\Base $flow, $options) {
		$this->flow = $flow ;

		if (empty($this->flow->getUrl())) {
			throw IllegalParamException::factory(sprintf("Url missing, action [%s]", $this->flow->getAction())) ;
		}
		
		$this->options = $options ;
		
		$this->handle() ;
	}

	protected function handle() {
		$this->handler = new cURL() ;
		
		$url = $this->flow->getUrl() ;
		
		$data = $this->flow->getOrder()->toArray() ;
		if ($this->data_format === 'xml') {
			$data = \payment\util\DataFormat::array2xml($data) ;
		}
		
		if ($this->method == 'get') {
			$data = http_build_query($data) ;
			$url .= '?' . $data ;
			$data = '' ;
		}

		$this->handler_request = $this->handler->newRequest($this->method, $url , $data, static::$encoding_table[$this->encoding]) ;
		
		if (!empty($this->options['headers'])) {
			$this->handler_request->setHeaders($this->options['headers']) ;
		}
		
		if (!empty($this->options['options'])) {
			$this->handler_request->setOptions($this->options['options']) ;
		}
		
	}
	
	abstract public function send() ;
	
	
}
