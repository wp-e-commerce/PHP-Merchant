<?php

require_once( 'paypal-express-checkout.php' );
require_once( 'paypal-express-checkout-response.php' );

class PHP_Merchant_Paypal_Digital_Goods extends PHP_Merchant_Paypal_Express_Checkout
{
	public function __construct( $options = array() ) {
		parent::__construct( $options );
	}

	protected function add_payment( $action ) {
		$request = parent::add_payment( $action );

		// Make sure PayPal knows all goods are digital
		for( $i = 0; $i < count( $this->options['items'] ); $i++ )
			$request += array( "L_PAYMENTREQUEST_0_ITEMCATEGORY{$i}" => 'Digital',

		return $request;
	}

}