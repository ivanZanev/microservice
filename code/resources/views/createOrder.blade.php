<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

		<script type="text/javascript" src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
		<div id="app">
			<h1>Microservice</h1>
			<h2>Create Order</h2>

			<p>Use the form below to create a simple order. Once created, the order will be scheduled for delivery and a message is going to be sent via the Twilio SMS service.</p>

			@if ($message = Session::get('success'))
			<div class="alert alert-success alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>    
				<strong>{{ $message }}</strong>
			</div>
			@endif

			@if ($message = Session::get('error'))
			<div class="alert alert-danger alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>    
				<strong>{{ $message }}</strong>
			</div>
			@endif

			<div class="flex-center position-ref full-height">
				<form method="POST" action="{{ route('messages.createOrder') }}" enctype="multipart/form-data">
					@csrf

					<label for="restaurant_id">Choose Restaurant:</label>
					<select id="restaurant_id" name="restaurant_id" value="{{ old('restaurant_id', $formData['restaurant_id']) }}">
						@foreach ($restaurants as $restaurant):
						<option value="{{ $restaurant->id }}">{{ $restaurant->name }} - {{ $restaurant->delivery_time_minutes }} minutes</option>
						@endforeach
					</select>

					<label for="client_id">Choose Client:</label>
					<select id="client_id" name="client_id" value="{{ old('client_id', $formData['client_id']) }}">
						@foreach ($clients as $client)
						<option value="{{ $client->id }}">{{ $client->name }} - {{ $client->phone_number }}</option>
						@endforeach
					</select>

					<button type="submit">Create Order</button>
				</form>
			</div>

			<a href="{{ route('messages.home') }}">Back</a>
		</div>
    </body>
</html>
