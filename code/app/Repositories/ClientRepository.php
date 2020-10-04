<?php

namespace App\Repositories;

use App\Client as Model;

class ClientRepository {
	public function loadAll() {
		$collection = Model::all();

		return $collection;
	}
}