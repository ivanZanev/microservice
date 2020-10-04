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
			<h2>View Messages</h2>

			<form method="GET" action="{{ route('messages.view') }}" enctype="x-www-form-urlencoded">
				<label for="text">Message Text:</label>

				<input id="text" name="text" type="text" class="@error('text') is-invalid @enderror" value="{{ old('text', $filterText) }}">

				@error('text')
					<div class="alert alert-danger">{{ $message }}</div>
				@enderror

				<button type="submit">Filter</button>
			</form>

			<div class="flex-center position-ref full-height">
				<p>Messages:</p>
				<table class="table table-striped">
				<thead>
					<tr>
						<th>ID</th>
						<th>Text</th>
						<th>Date Sent</th>
						<th>Status</th>
						<th>Error Code</th>
						<th>Error Message</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($messages as $message)
					<tr class="">
						<td>{{ $message->id }}</td>
						<td>{{ $message->text }}</td>
						<td>{{ $message->twilio_date_sent }}</td>
						<td>{{ $message->twilio_status }}</td>
						<td>{{ $message->twilio_error_code }}</td>
						<td>{{ $message->twilio_error_message }}</td>
					</tr>
					@endforeach
				</tbody>
				</table>
			</div>

			<a href="{{ route('messages.home') }}">Back</a>
		</div>
    </body>
</html>
