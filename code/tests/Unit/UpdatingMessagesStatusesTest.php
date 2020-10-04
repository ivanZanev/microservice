<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

use App\Message;
use App\Repositories\MessageRepository;
use App\Services\SendMessage as SendMessage;
use App\Console\UpdateMessagesStatuses;

class UpdatingMessagesStatusesTest extends TestCase
{
	use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
		// Create three App\User instances...
		factory(Message::class, 1)->states('accepted')->create([
			'order_id' => 1,
			'twilio_sid' => 'SMXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX1'
		]);
		factory(Message::class, 1)->states('accepted')->create([
			'order_id' => 1,
			'twilio_sid' => 'SMXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX2'
		]);
		factory(Message::class, 2)->states('read')->create([
			'order_id' => 1,
			'twilio_sid' => 'SMXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX3'
		]);

		$originalCount = 2;

		$twilioMessage = new \stdClass;
		$twilioMessage->status = Message::TWILIO_STATUS_DELIVERED;

		$mockedService = Mockery::mock('App\Services\Twilio');
		$mockedService->shouldReceive('getMessageById')
			->twice()
			->andReturn($twilioMessage);

		$repository = new MessageRepository;

		$updateMessagesStatuses = new UpdateMessagesStatuses($repository, new SendMessage($mockedService, $repository));
		$updateMessagesStatuses->__invoke();

		$message1 = $repository->findByTwillioId("SMXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX1");
		$this->assertEquals(Message::TWILIO_STATUS_DELIVERED, $message1->twilio_status);

		$newCount = $repository->findForStatusUpdate()->count();

		$this->assertEquals($originalCount, $newCount);
    }
}
