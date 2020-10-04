<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
			$table->foreignId('order_id');
			$table->text('text');
			$table->char('twilio_sid', 38);
			$table->char('twilio_status', 20);
			$table->boolean('is_delivered')->default(false);
			$table->integer('twilio_error_code')->nullable();
			$table->text('twilio_error_message')->nullable();
			$table->dateTime('twilio_date_sent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
