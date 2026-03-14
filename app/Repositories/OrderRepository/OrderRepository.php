<?php

namespace App\Repositories\OrderRepository;

use App\Repositories\BaseRepository;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface {

	public function getModel()
	{
		return \App\Models\Order::class;
	}
}