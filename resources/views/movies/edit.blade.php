@extends('layouts.app')

@section('content')
<div class="container">
	
	<div class="row">
		<div class="col-12">
			<h1>@lang('app.movie_edit', ['title' => $movie->title])</h1>
		</div>
	</div>

	
	<div class="row">
		<div class="col-12">
			{!! Form::open([
				'url' => route('movies.update', ['id' => $movie->id]),
				'method' => 'PATCH',
			]) !!}
				
				{{-- ================= MOVIE TITLE ================= --}}
				<div class="form-group">
					{{ Form::label('title', __('app.movie_title')) }}
					{{ Form::text('title', $movie->title, [
						'required',
						'class' => 'form-control'
					]) }}

					@if($errors->has('title'))
						<small id="passwordHelpBlock" class="form-text text-danger">
    						{{ $errors->first('title') }}						  
						</small>
					@endif
				</div>

				{{-- ================= MOVIE DIRECTOR ================= --}}
				<div class="form-group">
					{{ Form::label('director', __('app.movie_director')) }}
					{{ Form::text('director', $movie->director ? $movie->director->name : null, [
						'class' => 'form-control'
					]) }}

					@if($errors->has('director'))
						<small id="passwordHelpBlock" class="form-text text-danger">
    						{{ $errors->first('director') }}						  
						</small>
					@endif
				</div>

				{{-- ================= MOVIE TYPE ================= --}}
				<div class="form-group">
					{{ Form::label('types', __('app.movie_type')), [
						'aria-describedby' => 'typesHelp',
					] }}
					<small id="typesHelp" class="form-text text-muted">{{ __('app.movie_type_helper') }}</small>
					{{ Form::text('types', $types_names, [
						'class' => 'form-control'
					]) }}

					@if($errors->has('types'))
						<small id="passwordHelpBlock" class="form-text text-danger">
    						{{ $errors->first('types') }}						  
						</small>
					@endif
				</div>

				{{-- ================= MOVIE RATING ================= --}}
				<div class="form-group">
					
					{{-- Do not know --}}
					<div class="form-check">
						{{ Form::radio('rating', 'empty', !$movie->rating, [
							'id' => 'ratingDoNotKnow',
							'class' => 'form-check-input',
						])}}
						{{ Form::label('ratingDoNotKnow', __('app.movie_rating_do_not_know'), [
							'class' => 'form-check-label',
						]) }}
					</div>
					
					{{-- Fantastic --}}
					<div class="form-check">
						{{ Form::radio('rating', "fantastic", $movie->rating === 'fantastic', [
							'id' => 'ratingFantastic',
							'class' => 'form-check-input',
						])}}
						{{ Form::label('ratingFantastic', __('app.movie_rating_fantastic'), [
							'class' => 'form-check-label',
						]) }}
					</div>

					{{-- Bad --}}
					<div class="form-check">
						{{ Form::radio('rating', "bad", $movie->rating === 'bad', [
							'id' => 'ratingBad',
							'class' => 'form-check-input',
						])}}
						{{ Form::label('ratingBad', __('app.movie_rating_bad'), [
							'class' => 'form-check-label',
						]) }}
					</div>

					@if($errors->has('rating'))
						<small id="passwordHelpBlock" class="form-text text-danger">
    						{{ $errors->first('rating') }}						  
						</small>
					@endif
				</div>

				{{-- ================= MOVIE POSSESSION STATE ================= --}}
				<div class="form-group">

					{{-- Default --}}
					<div class="form-check">
						{{ Form::radio('possession_state', 'empty', !$movie->possession_state, [
							'id' => 'stateDefault',
							'class' => 'form-check-input',
						])}}
						{{ Form::label('stateDefault', __('app.movie_possession_state_default'), [
							'class' => 'form-check-label',
						]) }}
					</div>

					{{-- Own --}}
					<div class="form-check">
						{{ Form::radio('possession_state', "own", $movie->possession_state === 'own', [
							'id' => 'stateOwn',
							'class' => 'form-check-input',
						])}}
						{{ Form::label('stateOwn', __('app.movie_possession_state_own'), [
							'class' => 'form-check-label',
						]) }}
					</div>

					{{-- To own --}}
					<div class="form-check">
						{{ Form::radio('possession_state', "to_own", $movie->possession_state === 'to_own', [
							'id' => 'stateToOwn',
							'class' => 'form-check-input',
						])}}
						{{ Form::label('stateToOwn', __('app.movie_possession_state_to_own'), [
							'class' => 'form-check-label',
						]) }}
					</div>

					@if($errors->has('possession_state'))
						<small id="passwordHelpBlock" class="form-text text-danger">
    						{{ $errors->first('possession_state') }}						  
						</small>
					@endif
				</div>

				{{-- ================= MOVIE IMAGE ================= --}}
				<div class="form-group">
					{{ Form::label('image', __('app.movie_image')) }}
					{{ Form::text('image', $movie->image, [
						'class' => 'form-control'
					]) }}

					@if($errors->has('image'))
						<small id="passwordHelpBlock" class="form-text text-danger">
    						{{ $errors->first('image') }}						  
						</small>
					@endif
				</div>

				{{-- ================= FORM SUBMIT ================= --}}
				<a href="{{ route('movies.index') }}" class="btn btn-secondary">
					{{ __('app.cancel') }}
				</a>
				{{ Form::submit( __('app.save'), [
					'class' => 'btn btn-primary',
				])}}

			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection