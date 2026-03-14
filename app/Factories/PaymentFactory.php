<?php

namespace App\Factories;

use App\Services\Payment\PayPayPayment;
use App\Services\Payment\StripePayment;

class PaymentFactory {
	public static function create($processer) 
	{
		return match($processer) {
			'stripe' => new StripePayment(),
			'paypay' => new PayPayPayment(),
			'default' => throw new \InvalidArgumentException('Invalid payment processor'),
		};
	}
}