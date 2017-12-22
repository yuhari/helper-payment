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
 * 订单 class
 */
namespace payment\order ;

use payment\exception\IllegalParamException ;

abstract class Base {
	
	//订单参数
	protected $sets = array() ;
	
	//订单参数的约束条件，如果不设置则不检查
	protected $constrains = array() ;
	
	//默认检查约束
	public $check_constrains = true ;
	
	//构造函数
	public function __construct($params = array()) {
		if (!empty($params)) {
			foreach($params as $key=>$value) {
				$this->$key = $value ;
			}
		}
	}
	
	public function __set($key, $value) {
		$this->sets[$key] = $value ;
	}
	
	public function __get($key) {
		return isset($this->sets[$key]) ? $this->sets[$key] : null ;
	}
	
	public function getParams() {
		return $this->sets ;
	}
	
	/**
	 * 订单预处理，检查参数等
	 *
	 * @return void
	 */
	public function prepare() {
		if ($this->checkConstrains()){
			
		}else{
			throw new IllegalParamException("constrains not satisfy.") ;
		}
		
		return $this ;
	}
	
	/**
	 * 返回约束
	 *
	 * @return void
	 */
	protected function getConstrains() {
		return $this->constrains ;
	}
	
	/**
	 * 检查约束条件
	 *
	 * @return boolean
	 */
	public function checkConstrains($constrains = null) {
		
		if (!$this->check_constrains) return true ;
		
		if ($constrains === null) {
			$constrains = $this->getConstrains() ;
		}
				
		//必须的参数检查
		if (!empty($constrains['required'])){
			foreach($constrains['required'] as $key) {
				if (!isset($this->sets[$key])) {
					return false ;
				}
			}
		}
		
		//可用的参数检查，如果不设置认为剩下的参数都是订单参数
		if (!empty($constrains['enabled'])) {
			$t = array() ;
			foreach($constrains['enabled'] as $key) {
				if (isset($this->sets[$key])) {
					$t[$key] = $this->sets[$key] ;
				}
			}
			$this->sets = $t ;
		}
		
		//不可用参数检查，即过滤些无用参数
		if (!empty($constrains['disabled'])) {
			foreach($constrains['disabled'] as $key) {
				if (isset($this->sets[$key])) {
					unset($this->sets[$key]) ;
				}
			}
		}
		
		//依赖关系，有些参数可能是可以同时存在或同时不存在的
		if (!empty($constrains['rely'])) {
			foreach($constrains['rely'] as $key=>$records) {
				foreach($records as $record) {
					if (isset($this->sets[$key])){
						if (isset($record['value'])) {
							//有些参数必须为特定的值,支持单个值或多个值数组
							if (!is_array($record['value'])) $record['value'] = array($record['value']) ;
						
							if (!empty($record['must']) && !in_array($this->sets[$key], $record['value'])) return false ;
						
							if (in_array($this->sets[$key],$record['value'])) {
								return $this->checkConstrains($record) ;
							}
						}
					}
				}
			}
		}
		
		return true ;
	}
	
	/**
	 * 打印order信息
	 *
	 * @return mixed
	 */
	public function dump() {
		foreach ($this->sets as $k => $v) {
			echo sprintf("%s => %s \n", $k , $v) ;
		}
	}
	
	/**
	 * toArray
	 *
	 * @return string
	 */
	public function toArray() {
		return $this->sets ;
	}
}
