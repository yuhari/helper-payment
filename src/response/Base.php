<?php
/**
 * 
 *
 * @author yuhari
 * @version $Id$
 * @copyright , 22 December, 2017
 * @package default
 */

/**
 * payment response
 */
namespace payment\response ;

use anlutro\cURL\Response ;

class Base {
	
	protected $response ;
	
	protected $request ;
	
	//body处理后的内容
	public $content ;
	
	protected $data_format = '' ; // default || xml || json
	
	public function __construct(Response $response, \payment\request\Base $request) {
		$this->response = $response ;
		
		$this->request = $request ;
		
		$this->handle() ;
	}
	
	public function __get($key) {
		return $this->response->{$key} ;
	}
	
	protected function handle() {
		$content = $this->body ;
		if ($this->data_format == 'xml') {
			$content = \payment\util\DataFormat::xml2array($content) ;
		}elseif ($this->data_format == 'json') {
			$content = \payment\util\DataFormat::json2array($content) ;
		}
		
		$this->content = $content ;
		
		$this->after() ;
	}
	
	/**
	 * after operation 
	 *
	 * @return void
	 */
	protected function after() {
		
	}
}
