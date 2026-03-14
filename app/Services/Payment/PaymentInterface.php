<?php

namespace App\Services\Payment;

use App\Models\Order;

interface PaymentInterface {
	public function pay(Order $order);

	public function checkPayment(Order $order);
}