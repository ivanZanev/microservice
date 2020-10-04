<?php

namespace App\Repositories;

use App\Restaurant as Model;

class RestaurantRepository {
	public function loadAll() {
		$restaurantsCollection = Model::all();

		return $restaurantsCollection;
	}
}