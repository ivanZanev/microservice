<?php

namespace App\Http\Controllers;

use App\Repositories\MessageRepository;
use App\Repositories\RestaurantRepository;
use App\Repositories\ClientRepository;

use App\Services\SendMessage as SendMessageService;
use App\Services\PlaceOrder as PlaceOrderService;

use App\Client;
use App\Restaurant;
use App\Order;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class MessagesController extends BaseController
{
	protected $messageRepository;
	protected $restaurantRepository;
	protected $clientRepository;
	protected $sendMessageService;
	protected $placeOrderService;

	public function __construct(MessageRepository $messageRepository, 
		RestaurantRepository $restaurantRepository, 
		ClientRepository $clientRepository,
		SendMessageService $sendMessageService, 
		PlaceOrderService $placeOrderService) {
		$this->messageRepository = $messageRepository;
		$this->restaurantRepository = $restaurantRepository;
		$this->clientRepository = $clientRepository;
		$this->sendMessageService = $sendMessageService;
		$this->placeOrderService = $placeOrderService;
	}

	public function index() {
		return view('index');
	}

	public function view(Request $request) {
		$filterText = $request->text;

		$messagesCollection = $this->messageRepository->findAll($filterText);

		return view('viewMessages', [
			'filterText' => $filterText,
			'messages' => $messagesCollection,
		]);
	}

	public function fillOrder(Request $request) {
		$formData = [
			'restaurant_id' => $request->restaurant_id,
			'client_id' => $request->client_id
		];

		$restaurantsCollection = $this->restaurantRepository->loadAll();
		$clientsCollection = $this->clientRepository->loadAll();

		return view('createOrder', [
			'formData' => $formData,
			'restaurants' => $restaurantsCollection,
			'clients' => $clientsCollection
		]);
	}

	public function submitOrder(Request $request) {
		$formData = [
			'restaurant_id' => $request->restaurant_id,
			'client_id' => $request->client_id
		];

		$client = Client::find($formData['client_id']);

		if (!$client) {
			return back();
		}

		$restaurant = Restaurant::find($formData['restaurant_id']);

		if (!$restaurant) {
			return back();
		}

		try {
			$this->placeOrderService->placeOrder($restaurant, $client);
		} catch (\Exception $ex) {
			return back()->with('error', 'Could not place order. Error: ' . $ex->getMessage());
		}

		return back()->with('success', 'Order successfully created.');
	}
}
