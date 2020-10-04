<?php

namespace App\Console;

use App\Order;

use App\Repositories\MessageRepository;
use App\Services\SendMessage as SendMessageService;

use Illuminate\Support\Facades\Log;

class UpdateMessagesStatuses {
	protected $messageRepository;
	protected $sendMessageService;

	public function __construct(MessageRepository $messageRepository, SendMessageService $sendMessageService) {
		$this->messageRepository = $messageRepository;
		$this->sendMessageService = $sendMessageService;
	}

    public function __invoke()
    {
		$messagesCollection = $this->messageRepository->findForStatusUpdate();

		if ($messagesCollection->count()) {
			foreach ($messagesCollection as $message) {
				Log::info('Updating message status, twilio_sid=: ' . $message->twilio_sid);

				$this->sendMessageService->updateMessage($message);
			}
		}
    }
}