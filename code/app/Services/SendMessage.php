<?php

namespace App\Services;

use App\Order;
use App\Message;

use App\Repositories\MessageRepository;

class SendMessage {
	protected $twilioService;

	public function __construct(Twilio $twilioService, MessageRepository $messageRepository) {
		$this->twilioService = $twilioService;
		$this->messageRepository = $messageRepository;
	}

	public function updateMessage(Message $message) {
		$twilioMessage = $this->twilioService->getMessageById($message->twilio_sid); 

		$message->twilio_status = $twilioMessage->status;

		if ($twilioMessage->status == Message::TWILIO_STATUS_DELIVERED) {
			$message->is_delivered = true;
		}

		if (isset($twilioMessage->error_code)) {
			$message->twilio_error_code = $twilioMessage->error_code;
		}

		if (isset($twilioMessage->error_message)) {
			$message->twilio_error_message = $twilioMessage->error_message;
		}

		$this->messageRepository->save($message);
	}

	public function sendOrderPlacedMessage(Order $order) {
		$phoneNumber = $order->client->phone_number;
		$text = $this->generateOrderPlacedMessage($order);

		$twilioMessage = $this->twilioService->createMessage($phoneNumber,
		   [
			   "body" => $text
		   ]
		);

		$message = new Message();
		$message->order()->associate($order);
		$message->text = $text;
		$message->twilio_sid = $twilioMessage->sid;
		$message->twilio_status = $twilioMessage->status;

		$this->messageRepository->save($message);
	}

	public function sendOrderDeliveredMessage(Order $order) {
		$phoneNumber = $order->client->phone_number;
		$text = $this->generateOrderDeliveredMessage($order);

		$twilioMessage = $this->twilioService->createMessage($phoneNumber,
		   [
			   "body" => $text
		   ]
		);

		$message = new Message();
		$message->order()->associate($order);
		$message->text = $text;
		$message->twilio_sid = $twilioMessage->sid;
		$message->twilio_status = $twilioMessage->status;

		$this->messageRepository->save($message);
	}

	public function generateOrderDeliveredMessage(Order $order) {
		$name = $order->restaurant->name;

		$text = "Reminder: your order at restaurant " . $name . " has been delivered on " . $order->estimated_delivery_time;

		return $text;
	}

	public function generateOrderPlacedMessage(Order $order) {
		$name = $order->restaurant->name;

		$text = "Hey! Your just placed a take away order at restaurant " . $name . ". The estimated delivery time is " . $order->estimated_delivery_time;

		return $text;
	}
}