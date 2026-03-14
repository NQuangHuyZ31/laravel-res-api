<?php

namespace App\Http\Controllers\Api\V1;

use App\Factories\PaymentFactory;
use App\Http\Controllers\Controller;
use App\Services\OrderService;
use App\Services\Payment\StriptPayment;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function __construct(protected OrderService $orderService)
    {
        
    }

    public function create(Request $request) 
    {
        $paymentProcesser = PaymentFactory::create($request->input("payment_method"));

        $order = $this->orderService->create($request->all());

        return response()->json([
            'status' => $paymentProcesser->pay($order)
        ]);
    }

    public function check(Request $request) 
    {
        $paymentProcesser = PaymentFactory::create($request->input("payment_method"));

        $order = $this->orderService->create($request->all());

        return response()->json([
            'status' => $paymentProcesser->checkPayment($order)
        ]);
    }
}
