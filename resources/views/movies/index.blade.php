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
					<li class="mb-2">
						{{ $movie->title }}
						
						{{-- ================= EDIT BUTTON ================= --}}
						<a href="{{ route('movies.edit', ['id' => $movie->id]) }}" class="d-inline-block btn btn-secondary btn-sm">{{ __('app.edit') }}</a>
						
						{{-- ================= DELETE FORM ================= --}}
						{!! Form::open([
							'url' => route('movies.destroy', ['id' => $movie->id]),
							'method' => 'DELETE',
							'class' => 'd-inline-block',
						]) !!}

							{{ Form::submit( 'X', [
								'title' => __('app.delete'),
								'class' => 'btn btn-danger btn-sm',
							])}}

						{!! Form::close() !!}
					</li>
				@endforeach
			</ul>
		</div>
	</div>
</div>
@endsection