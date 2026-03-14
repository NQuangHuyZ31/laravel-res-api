<?php

namespace App\Services\Payment;

use App\Helpers\PaymentStatus;
use App\Models\Order;

class StripePayment implements PaymentInterface {

	public function pay(Order $order) : PaymentStatus
	{
		return PaymentStatus::PROCESSING;
	}

	public function checkPayment(Order $order) : PaymentStatus
	{
		return PaymentStatus::SUCCESS;
	}
}