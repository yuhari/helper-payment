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
 * 一个支付流程 基础类
 */
namespace payment\flow ;

use config\Factory as ConfigFactory ;

use payment\exception\FileNotFoundException ;

abstract class Base implements IBase {
	
	//当前装载的订单
	protected $order ;
	
	//不同的支付途径，如wechat,ali从而使用对应的配置
	protected $mode ;
	
	//支付流程所使用的固定参数配置
	protected $config = false ;
	
	//支付流程所使用的固定参数配置文件路径
	protected $config_path = '' ;
	
	//配置文件名
	protected $config_file = '' ;
	
	//使用固定的账户配置,默认名为default
	protected $account = 'default' ;
	
	//操作的接口url
	protected $url = '' ;
	
	//request
	public $request ;
	
	//action name , pay,query ...
	protected $action ;
	
	//构造函数
	public function __construct($configPath, $mode='', $configFile='config') {
		$file = realpath($configPath) . '/' . $configFile . '.ini' ;
		if (file_exists($file)) {
			$this->config_path = $configPath ;
			$this->config_file = $configFile ;
			
			if (!empty($mode)) {
				$this->mode = $mode ;
			}
		}else{
			throw FileNotFoundException::factory($file) ;
		}
	}
	
	//魔术方法, 如果需要使用get变量
	public function __call($name, $args) {
		if (preg_match('#^get(\w+)$#', $name, $matches)){
			$property = strtolower($matches[1]) ;
			$res = $this->{$property} ;
			if (empty($args)) {
				return $res ;
			}else{
				$list = array() ;
				foreach($args as $arg) {
					$list[] = isset($res[$arg]) ? $res[$arg] : null ;
				}
				if (count($list) == 1) {
					$list = $list[0] ;
				}
				return $list ;
			}
			return $list ;
		}else {
			$this->prepare() ;
			
			$this->action = $name ;
			
			return $this->execute($name, $args) ;
		}
		
		return null ;
	}
	
	/**
	 * 行为前的准备
	 *
	 * @return void
	 */
	public function prepare() {
		if ($this->config === false) {
			ConfigFactory::init($this->config_path, $this->mode) ;
			$this->config = ConfigFactory::get($this->config_file .'.'. $this->account . '.*') ;
		}
		
		$this->order->prepare() ;
		
		return $this ;
	}
		
	/**
	 * 执行具体的操作，根据config中定义的url
	 *
	 * @return void
	 */
	abstract protected function execute($action, $arguments) ;
	
	/**
	 * 如果使用其他账户需要load
	 *
	 * @return void
	 */
	public function loadAccount($account) {
		$this->account = $account ;
		
		return $this ;
	}
	
	/**
	 * 加载使用的配置模式
	 *
	 * @return this
	 */
	public function loadMode($mode){
		$this->mode = $mode ;
		
		return $this ;
	}
	
	/**
	 * 装载一个操作订单
	 *
	 * @return this
	 */
	public function loadOrder(\payment\order\Base $order) {
		$this->order = $order ;
		
		return $this ;
	}
}
