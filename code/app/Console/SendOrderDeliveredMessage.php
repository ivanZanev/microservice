<?php

namespace App\Console;

use App\Order;

use App\Repositories\OrderRepository;
use App\Services\SendMessage as SendMessageService;

class SendOrderDeliveredMessage {
	protected $orderRepository;
	protected $sendMessageService;

	public function __construct(OrderRepository $orderRepository, SendMessageService $sendMessageService) {
		$this->orderRepository = $orderRepository;
		$this->sendMessageService = $sendMessageService;
	}

    public function __invoke()
    {
		$ordersCollection = $this->orderRepository->findForDeliveryMessageNotification();

		if ($ordersCollection->count()) {
			foreach ($ordersCollection as $order) {
				$this->sendMessageService->sendOrderDeliveredMessage($order);

				$order->delivery_notification_sent = true;
				$order->save();
			}
		}
    }
}