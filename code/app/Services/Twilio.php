<?php

namespace App\Services;

use Twilio\Rest\Client;

use App\Order;
use App\Message;

class Twilio {
	protected $twilioClient;
	
	protected $settings = [];

	public function __construct(Client $twilioClient, array $settings) {
		$this->settings = $settings;
		$this->twilioClient = $twilioClient;
	}

	public function getMessageById($twilioSid) {
		return $this->twilioClient->messages($twilioSid)->fetch();
	}

	public function createMessage($phoneNumber, $messageData) {
		if (!isset($messageData['from'])) {
			$messageData['from'] = $this->settings['from'];
		}

		return $this->twilioClient->messages->create($phoneNumber, $messageData);
	}
}