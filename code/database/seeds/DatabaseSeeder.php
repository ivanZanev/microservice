<?php

use Illuminate\Database\Seeder;

use App\Client;
use App\Message;
use App\Restaurant;
use App\Order;

use App\Services\SendMessage;

class DatabaseSeeder extends Seeder
{
	protected $messageService;

	public function __construct(SendMessage $messageService) {
		$this->messageService = $messageService;
	}

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
		$client1 = new Client();
		$client1->name = "Ivan";
		$client1->phone_number = "+359899159211";
		$client1->save();

		$restaurant1 = new Restaurant();
		$restaurant1->name = "DunnerLand";
		$restaurant1->delivery_time_minutes = 120;
		$restaurant1->save();

		$restaurant2 = new Restaurant();
		$restaurant2->name = "KebapToGo";
		$restaurant2->delivery_time_minutes = 60;
		$restaurant2->save();

		$restaurant3 = new Restaurant();
		$restaurant3->name = "BreadAndButter";
		$restaurant3->delivery_time_minutes = 40;
		$restaurant3->save();

		$order1 = new Order();
		$order1->client()->associate($client1);
		$order1->restaurant()->associate($restaurant1);
		$order1->estimated_delivery_time = now()->addMinutes($restaurant1->delivery_time_minutes);
		$order1->save();

		for ($c = 0; $c < 30; $c++) {
			$message = new Message();
			$message->order()->associate($order1);
			$message->text = $this->messageService->generateOrderPlacedMessage($order1);
			$message->twilio_sid = "SMXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
			$message->twilio_status = Message::TWILIO_STATUS_FAILED;
			$message->twilio_error_code = "1239";
			$message->twilio_error_message = "Something went wrong.";
			$message->twilio_date_sent = now();
			$message->updated_at = now()->subHours(26);
			$message->save();
		}

		for ($c = 0; $c < 10; $c++) {
			$message = new Message();
			$message->order()->associate($order1);
			$message->text = $this->messageService->generateOrderPlacedMessage($order1);
			$message->twilio_sid = "SMXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
			$message->twilio_status = Message::TWILIO_STATUS_FAILED;
			$message->twilio_error_code = "1239";
			$message->twilio_error_message = "Something went wrong.";
			$message->twilio_date_sent = now();
			$message->save();
		}

		for ($c = 0; $c < 30; $c++) {
			$message = new Message();
			$message->order()->associate($order1);
			$message->text = $this->messageService->generateOrderPlacedMessage($order1);
			$message->twilio_sid = "SMXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
			$message->twilio_status = Message::TWILIO_STATUS_DELIVERED;
			$message->twilio_date_sent = now();
			$message->is_delivered = true;
			$message->save();
		}

		$order1 = new Order();
		$order1->client()->associate($client1);
		$order1->restaurant()->associate($restaurant2);
		$order1->estimated_delivery_time = now()->addMinutes($restaurant2->delivery_time_minutes);
		$order1->save();

		$order1 = new Order();
		$order1->client()->associate($client1);
		$order1->restaurant()->associate($restaurant3);
		$order1->estimated_delivery_time = now()->addMinutes($restaurant3->delivery_time_minutes);
		$order1->save();
    }
}
