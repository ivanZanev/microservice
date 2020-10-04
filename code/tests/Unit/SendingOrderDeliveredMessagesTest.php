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
use App\Services\SendMessage as SendMessage;
use App\Console\SendOrderDeliveredMessage;

class SendingOrderDeliveredMessagesTest extends TestCase
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
		$restaurant = factory(Restaurant::class)->create();

		factory(Order::class, 1)->create([
			'client_id' => $client->id,
			'restaurant_id' => $restaurant->id,
			'estimated_delivery_time' => now()->addHours(1)
		]);

		factory(Order::class, 1)->create([
			'client_id' => $client->id,
			'restaurant_id' => $restaurant->id,
			'estimated_delivery_time' => now()
		]);

		$order1 = factory(Order::class, 1)->create([
			'client_id' => $client->id,
			'restaurant_id' => $restaurant->id,
			'estimated_delivery_time' => now()->subMinutes(95)
		]);

		$twilioMessage = new \stdClass;
		$twilioMessage->sid = "SMXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX3";
		$twilioMessage->status = Message::TWILIO_STATUS_ACCEPTED;

		$mockedService = Mockery::mock('App\Services\Twilio');
		$mockedService->shouldReceive('createMessage')
			->once()
			->andReturn($twilioMessage);

		$orderRepository = new OrderRepository;
		$messageRepository = new MessageRepository;

		$ordersCollection = $orderRepository->findForDeliveryMessageNotification();
		$this->assertEquals(1, $ordersCollection->count());

		$updateMessagesStatuses = new SendOrderDeliveredMessage($orderRepository, new SendMessage($mockedService, $messageRepository));
		$updateMessagesStatuses->__invoke();

		$message1 = $messageRepository->findByTwillioId("SMXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX3");
		$this->assertNotNull($message1);

		$ordersCollection = $orderRepository->findForDeliveryMessageNotification();
		$this->assertEquals(0, $ordersCollection->count());

	}
}
