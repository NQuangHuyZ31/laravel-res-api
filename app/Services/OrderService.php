<?php

namespace App\Services;

use App\Repositories\OrderRepository\OrderRepositoryInterface;

class OrderService {

	public function __construct(protected OrderRepositoryInterface $orderRepository)
	{
		
	}

	public function create(array $data) {
		return $this->orderRepository->create($data);
	}
}