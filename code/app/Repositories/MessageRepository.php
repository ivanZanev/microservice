<?php

namespace App\Repositories;

use App\Message as Model;

class MessageRepository {
	public function loadMany($status, $text = null) {
		return Model::status($status)->get();
	}

	public function getSent($text) {
		return Model::sent()->text($text)->latestFirst()->get();
	}

	public function getRecentlyFailed($text) {
		return Model::failed()->recent()->text($text)->latestFirst()->get();
	}

	public function findForStatusUpdate() {
		return Model::forStatusUpdate()->get();
	}

	public function findById($id) {
		return Model::find($id);
	}

	public function findByTwillioId($sid) {
		return Model::where('twilio_sid', $sid)->first();
	}

	public function findAll($text) {
		return Model::index($text)->limit(50)->get();
	}

	public function save($message) {
		$message->save();
	}
}