<?php

namespace App\Services;

use App\Client;
use App\Order;
use App\Restaurant;

use App\Repositories\OrderRepository;

class PlaceOrder {
	protected $orderRepository;
	protected $sendMessage;

	public function __construct(OrderRepository $orderRepository, SendMessage $sendMessage) {
		$this->orderRepository = $orderRepository;
		$this->sendMessage = $sendMessage;
	}

	public function placeOrder(Restaurant $restaurant, Client $client) {
		$order = new Order();
		$order->client()->associate($client);
		$order->restaurant()->associate($restaurant);
		$order->estimated_delivery_time = now()->addMinutes($restaurant->delivery_time_minutes);

		$this->orderRepository->save($order);

		$this->sendMessage->sendOrderPlacedMessage($order);
	}
}