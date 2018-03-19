<?php

namespace modules\payment_direct_deposit\controllers;

use Exception;
use ErrorException;
use core\classes\exceptions\RedirectException;
use core\classes\renderable\Controller;
use core\classes\Config;
use core\classes\Database;
use core\classes\Email;
use core\classes\Response;
use core\classes\Template;
use core\classes\Language;
use core\classes\Request;
use core\classes\Encryption;
use core\classes\Model;
use core\classes\Pagination;
use core\classes\FormValidator;
use modules\checkout\classes\Cart;
use modules\checkout\classes\Order;
use modules\payment_square\classes\SquareAPI;

class PaymentDirectDeposit extends Controller {

	protected $permissions = [
	];

	public function getAllUrls($include_filter = NULL, $exclude_filter = NULL) {
		return [];
	}

	public function payment() {
		$this->module_config = $this->config->moduleConfig('\modules\payment_direct_deposit');
		$this->language->loadLanguageFile('checkout.php', 'modules'.DS.'checkout');
		$this->language->loadLanguageFile('administrator/orders.php', 'modules'.DS.'checkout');
		$this->language->loadLanguageFile('direct_deposit.php', 'modules'.DS.'payment_direct_deposit');
		$cart = new Cart($this->config, $this->database, $this->request);

		$currency = $this->module_config->currency;
		if (property_exists($this->config->siteConfig(), 'currency')) {
			$currency = $this->config->siteConfig()->currency;
		}

		if ($this->request->postParam('confirm') == 1) {
			$customer = $this->model->getModel('\core\classes\models\Customer');
			$customer = $customer->get(['id' => $this->getAuthentication()->getCustomerID()]);

			$billing  = $this->model->getModel('\core\classes\models\Address', $cart->getBillingAddress());
			$shipping = $this->model->getModel('\core\classes\models\Address', $cart->getShippingAddress());

			$order = new Order($this->config, $this->database, $cart);
			$checkout = $order->purchase('direct_deposit', $customer, $billing, $shipping);

			$status = $this->model->getModel('\modules\checkout\classes\models\CheckoutStatus');
			if ($checkout->shipping_address_id) {
				$checkout->status_id = $status->getStatusId('Processing');
			}
			else {
				$checkout->status_id = $status->getStatusId('Complete');
			}
			$checkout->update();

			$enc_checkout_id = Encryption::obfuscate($checkout->id, $this->config->siteConfig()->secret);

			$data = [
				'module_config' => $this->module_config,
				'deposit_description' => str_replace('-', ' ', $enc_checkout_id),
				'contents' => $cart->getContents(),
				'total' => $cart->getCartSellTotal(),
			];
			$template = $this->getTemplate('widgets/bank_details.php', $data, 'modules'.DS.'payment_direct_deposit');
			$bank_details = $template->render();
			$this->request->session->set(['checkout_note'], $bank_details);

			// send the emails
			$template = $this->getTemplate('widgets/bank_details_email.html.php', $data, 'modules'.DS.'payment_direct_deposit');
			$bank_details_email_html = $template->render();

			$template = $this->getTemplate('widgets/bank_details_email.txt.php', $data, 'modules'.DS.'payment_direct_deposit');
			$bank_details_email_txt = $template->render();

			$order->sendOrderEmails($checkout, $this->language, $bank_details_email_html, $bank_details_email_txt);

			// create the event
			$this->request->addEvent('Direct Deposit', $checkout->id, $cart->getGrandTotal(), $currency);

			// clear the cart
			$cart->clear();

			// goto the receipt
			throw new RedirectException($this->url->getUrl('Checkout', 'receipt', [$enc_checkout_id]));
		}

		$data = [
			'module_config' => $this->module_config,
			'contents' => $cart->getContents(),
			'total' => $cart->getCartSellTotal(),
		];
		$template = $this->getTemplate('pages/direct_deposit.php', $data, 'modules'.DS.'payment_direct_deposit');
		$this->response->setContent($template->render());
	}
}
