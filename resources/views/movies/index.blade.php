@extends('layouts.app')

@section('content')
<div class="container">
	
	<div class="row">
		<div class="col-12">
			<h1>@lang('app.movie_list_seen')</h1>
		</div>
		@if (session('status'))
			<div class="col-12">
				<div class=" alert alert-success">
					{{ session('status') }}
				</div>
			</div>
		@endif
	</div>

	
	<div class="row">
		<div class="col-12">
			<ul>
				@foreach($movies as $movie)
					<li>
						{{ $movie->title }}
					</li>
				@endforeach
			</ul>
		</div>
	</div>
</div>
@endsection