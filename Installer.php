<?php

namespace modules\payment_direct_deposit;

use ErrorException;
use core\classes\Config;
use core\classes\Database;
use core\classes\Language;
use core\classes\Model;
use core\classes\Menu;

class Installer {
	protected $config;
	protected $database;

	public function __construct(Config $config, Database $database) {
		$this->config = $config;
		$this->database = $database;
	}

	public function install() {
	}

	public function uninstall() {
	}

	public function enable() {
		$config = $this->config->getSiteConfig();
		$config['sites'][$this->config->getSiteDomain()]['checkout']['payment_methods']['direct_deposit'] = [
			'name' => 'Direct Deposit',
			'public' => '\modules\payment_direct_deposit\controllers\PaymentDirectDeposit',
			'administrator' => '\modules\payment_direct_deposit\controllers\administrator\PaymentDirectDeposit',
		];
		$this->config->setSiteConfig($config);
	}

	public function disable() {
		$config = $this->config->getSiteConfig();
		unset($config['sites'][$this->config->getSiteDomain()]['checkout']['payment_methods']['direct_deposit']);
		$this->config->setSiteConfig($config);
	}
}
