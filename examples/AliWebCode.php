<?php

include "../vendor/autoload.php" ;


function pay() {
	$order = new \payment\order\ali_old\WebCode() ;
	$order->out_trade_no = '1234567890' ;
	$order->total_fee = 0.01 ;
	$order->subject = '这是一个yuhari的测试demo' ;
	$order->goods_type = 0; 

	$flow = new \payment\flow\ali_old\WebCode('../config') ;
	$response = $flow->loadOrder($order)->pay() ;
	var_dump($response['request_url']) ; exit;
}

pay() ;