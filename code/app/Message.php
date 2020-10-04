<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
	const TWILIO_STATUS_ACCEPTED = "accepted";
	const TWILIO_STATUS_QUEUED = "queued";
	const TWILIO_STATUS_SENDING = "sending";
	const TWILIO_STATUS_SENT = "sent";
	const TWILIO_STATUS_FAILED = "failed";
	const TWILIO_STATUS_DELIVERED = "delivered";
	const TWILIO_STATUS_UNDELIVERED = "undelivered";
	const TWILIO_STATUS_RECEIVING = "receiving";
	const TWILIO_STATUS_RECEIVED = "received";
	const TWILIO_STATUS_READ = "read";

    public function order()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }

    public function scopeSent($query)
    {
        return $query->where('twilio_status', '=', "sent");
    }

    public function scopeFailed($query)
    {
        return $query->where('twilio_status', '!=', "sent");
    }

	public function scopeText($query, $text) {
		return $query->where('text', 'like', '%' . $text . '%');
	}

	public function scopeRecent($query) {
		return $query->where('created_at', '>=', now()->subDay());
	}

	public function scopeForStatusUpdate($query) {
		return $query->where('twilio_status', '!=', self::TWILIO_STATUS_READ);
	}

	public function scopeIndex($query, $text) {
		$query->where(function($query) {
			$query->where('twilio_status', '=', self::TWILIO_STATUS_DELIVERED);

			$query->orWhere(function($query) {
				$query->where('twilio_status', '!=', self::TWILIO_STATUS_DELIVERED);
				$query->where('updated_at', '>=', now()->subHours(24));
			});
		});

		if (!empty($text)) {
			$query->where('text', 'like', '%' . $text . '%');
		}

		$query->orderBy('is_delivered');
		$query->orderBy('updated_at', 'DESC');
	}
}
