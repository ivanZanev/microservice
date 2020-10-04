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
    }
}
