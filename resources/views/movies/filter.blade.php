@extends('layouts.app')

@section('content')
<div class="container">
	
	<div class="row">
		<div class="col-12">
			<h1>@lang('app.movie_filter')</h1>
		</div>
	</div>

	<a href="{{ route("movies.search") }}">
		Trad new search
	</a>

	@if(isset($movies))
		<h2>Results:</h2>
		@if(count($movies) > 0)
			<ul>
				@foreach($movies as $movie)
					<li>
						<p>
							{{ $movie->title }}
							<br>
							director: {{ $movie->director->name }}
							<br>
							types: 
							@foreach($movie->types as $type)
								{{ $type }} |
							@endforeach
							<br>
							possession_state: {{ $movie->possession_state }}
							<br>
							rating: {{ $movie->rating }}
						</p>
					</li>
				@endforeach
			</ul>

			{{ $movies->appends($request->all())->links() }}
		@else
			<p>None</p>
		@endif
	@endif
</div>
@endsection
