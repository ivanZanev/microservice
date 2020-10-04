<?php

namespace App\Http\Controllers;

use App\Repositories\MessageRepository;

use App\Message;

use App\Http\Resources\Message as MessageResource;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class ApiMessagesController extends BaseController
{
	protected $messageRepository;
	protected $restaurantRepository;
	protected $clientRepository;
	protected $sendMessageService;

	public function __construct(MessageRepository $messageRepository) {
		$this->messageRepository = $messageRepository;
	}

	public function index(Request $request) {
		$filterText = $request->text;

		return MessageResource::collection($this->messageRepository->findAll($filterText));
	}

	public function show(Message $message) {
		return new MessageResource($message);
	}
}
