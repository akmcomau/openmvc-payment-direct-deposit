<?php
$_MODULE = [
	'name' => 'Payment - Direct Deposit',
	'description' => 'Support for direct deposit within the checkout',
	'namespace' => '\\modules\\payment_direct_deposit',
	'config_controller' => 'administrator\\PaymentDirectDeposit',
	'controllers' => [
		'administrator\\PaymentDirectDeposit',
		'PaymentDirectDeposit'
	],
	'default_config' => [
		'currency' => 'AUD',
		'bank' => '',
		'bsb' => '',
		'account_number' => '',
	]
];
