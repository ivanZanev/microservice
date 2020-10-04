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
			<h2>Index</h2>
			
			<p>This is the index page of Microservice.</p>

			<p>Click on one of the links below to explore:</p>
			
			<a href="{{ route('messages.view') }}">View Messages</a><br />
			<a href="{{ route('messages.fillOrder') }}">Place Test Order</a>
		</div>
    </body>
</html>
