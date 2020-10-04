<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

use App\Client;
use App\Message;
use App\Order;
use App\Restaurant;
use App\Repositories\MessageRepository;
use App\Repositories\OrderRepository;
use App\Services\PlaceOrder as PlaceOrderService;
use App\Services\SendMessage as SendMessage;

class SendingOrderPlacedMessagesTest extends TestCase
{
	use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
		$client = factory(Client::class)->create();
		$restaurant = factory(Restaurant::class)->states('delivery_60')->create();

		$twilioMessage = new \stdClass;
		$twilioMessage->sid = "SMXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX3";
		$twilioMessage->status = Message::TWILIO_STATUS_ACCEPTED;

		$mockedService = Mockery::mock('App\Services\Twilio');
		$mockedService->shouldReceive('createMessage')
			->once()
			->andReturn($twilioMessage);

		$orderRepository = new OrderRepository;
		$messageRepository = new MessageRepository;

		$placeOrderService = new PlaceOrderService($orderRepository, new SendMessage($mockedService, $messageRepository));
		$placeOrderService->placeOrder($restaurant, $client);

		$message1 = $messageRepository->findByTwillioId("SMXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX3");
		$this->assertNotNull($message1);
	}
}
