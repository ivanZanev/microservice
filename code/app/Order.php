<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function client()
    {
        return $this->belongsTo('App\Client', 'client_id');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant', 'restaurant_id');
    }

	public function scopeForDeliveryNotification($query) {
		return $query->where('estimated_delivery_time', '<=', now()->subMinutes(90))
			->where('delivery_notification_sent', '=', false);
	}
}
