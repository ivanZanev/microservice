<?php

namespace App\Repositories;

use App\Order as Model;

class OrderRepository {
	public function findForDeliveryMessageNotification() {
		$ordersCollection = Model::forDeliveryNotification()->get();

		return $ordersCollection;
	}

	public function save(Model $order) {
		$order->save();
	}
}