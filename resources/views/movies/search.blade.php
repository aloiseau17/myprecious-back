@extends('layouts.app')

@section('content')
<div class="container">
	
	<div class="row">
		<div class="col-12">
			<h1>@lang('app.movie_filter')</h1>
		</div>
	</div>

	
	<div class="row">
		<div class="col-12">
			{!! Form::open([
				'url' => route('movies.filter'),
				'method' => 'GET',
			]) !!}

				{{-- ================= MOVIE POSSESSION STATE ================= --}}
				<div class="form-group">

					{{-- Default --}}
					<div class="form-check">
						{{ Form::radio('possession_state', '', true, [
							'id' => 'stateDefault',
							'class' => 'form-check-input',
						])}}
						{{ Form::label('stateDefault', __('app.movie_possession_state_default'), [
							'class' => 'form-check-label',
						]) }}
					</div>

					{{-- Own --}}
					<div class="form-check">
						{{ Form::radio('possession_state', "own", old('possession_state') === "own" ?: false, [
							'id' => 'stateOwn',
							'class' => 'form-check-input',
						])}}
						{{ Form::label('stateOwn', __('app.movie_possession_state_own'), [
							'class' => 'form-check-label',
						]) }}
					</div>

					{{-- To own --}}
					<div class="form-check">
						{{ Form::radio('possession_state', "to_own", old('possession_state') === "to_own" ?: false, [
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
				
				{{-- ================= MOVIE RATING ================= --}}
				<div class="form-group">
					
					{{-- Do not know --}}
					<div class="form-check">
						{{ Form::radio('rating', '', true, [
							'id' => 'ratingDoNotKnow',
							'class' => 'form-check-input',
						])}}
						{{ Form::label('ratingDoNotKnow', __('app.movie_rating_do_not_know'), [
							'class' => 'form-check-label',
						]) }}
					</div>
					
					{{-- Fantastic --}}
					<div class="form-check">
						{{ Form::radio('rating', "fantastic", old('rating') === "fantastic" ?: false, [
							'id' => 'ratingFantastic',
							'class' => 'form-check-input',
						])}}
						{{ Form::label('ratingFantastic', __('app.movie_rating_fantastic'), [
							'class' => 'form-check-label',
						]) }}
					</div>

					{{-- Bad --}}
					<div class="form-check">
						{{ Form::radio('rating', "bad", old('rating') === "bad" ?: false, [
							'id' => 'ratingBad',
							'class' => 'form-check-input',
						])}}
						{{ Form::label('ratingBad', __('app.movie_rating_bad'), [
							'class' => 'form-check-label',
						]) }}
					</div>

					@if($errors->has('rating'))
						<small class="form-text text-danger">
    						{{ $errors->first('rating') }}						  
						</small>
					@endif
				</div>

				{{-- ================= MOVIE TYPE ================= --}}
				<div class="form-group">
					{{ Form::label('type', __('app.movie_type')), [
						'aria-describedby' => 'typesHelp',
					] }}
					<small id="typesHelp" class="form-text text-muted">{{ __('app.movie_type_helper') }}</small>
					{{ Form::text('type', old('type') ?: null, [
						'class' => 'form-control'
					]) }}

					@if($errors->has('type'))
						<small class="form-text text-danger">
    						{{ $errors->first('type') }}						  
						</small>
					@endif
				</div>

				{{-- ================= MOVIE DIRECTOR ================= --}}
				<div class="form-group">
					{{ Form::label('director', __('app.movie_director')) }}
					{{ Form::text('director', old('director') ?: null, [
						'class' => 'form-control'
					]) }}

					@if($errors->has('director'))
						<small class="form-text text-danger">
    						{{ $errors->first('director') }}						  
						</small>
					@endif
				</div>

				{{-- ================= MOVIE STARTING LETTER ================= --}}
				<div class="form-group">
					{{ Form::label('first_letter', __('app.first_letter')) }}
					{{ Form::text('first_letter',  old('first_letter') ?: null, [
						'class' => 'form-control'
					]) }}

					@if($errors->has('first_letter'))
						<small class="form-text text-danger">
    						{{ $errors->first('first_letter') }}						  
						</small>
					@endif
				</div>

				{{-- ================= ORDER BY ================= --}}
				<div class="form-group">
					{{ Form::label('order_by', __('app.order_by')) }}
					{{ Form::select(
						'order_by',
						[
							'created_at' => __('app.creation_date'),
							'title' => __('app.title')
						], 
						old('order_by') ?: null,
						[
							'class' => 'form-control'
						]
					) }}

					@if($errors->has('order_by'))
						<small class="form-text text-danger">
    						{{ $errors->first('order_by') }}						  
						</small>
					@endif
				</div>

				{{-- ================= ORDER ================= --}}
				<div class="form-group">
					{{ Form::label('order', __('app.order')) }}
					{{ Form::select(
						'order',
						[
							'ASC' => __('app.asc'),
							'DESC' => __('app.desc')
						],
						old('order') ?: null,
						[
							'class' => 'form-control'
						]
					) }}

					@if($errors->has('order'))
						<small class="form-text text-danger">
    						{{ $errors->first('order') }}						  
						</small>
					@endif
				</div>

				{{-- ================= PAGE NUMBER ================= --}}
				<div class="form-group">
					{{ Form::label('page', __('app.page')) }}
					{{ Form::text('page', old('page') ?: null, [
						'class' => 'form-control'
					]) }}

					@if($errors->has('page'))
						<small class="form-text text-danger">
    						{{ $errors->first('page') }}						  
						</small>
					@endif
				</div>

				{{-- ================= NUMBER ================= --}}
				<div class="form-group">
					{{ Form::label('number', __('app.number')) }}
					{{ Form::number('number', old('number') ?: null, [
						'class' => 'form-control'
					]) }}

					@if($errors->has('number'))
						<small class="form-text text-danger">
    						{{ $errors->first('number') }}						  
						</small>
					@endif
				</div>

				{{-- ================= NOT IN ================= --}}
				<div class="form-group">
					{{ Form::label('not_in', __('app.not_in')), [
						'aria-describedby' => 'notInHelp',
					] }}
					<small id="notInHelp" class="form-text text-muted">{{ __('app.not_in_helper') }}</small>
					{{ Form::text('not_in', old('not_in') ?: null, [
						'class' => 'form-control'
					]) }}

					@if($errors->has('not_in'))
						<small class="form-text text-danger">
    						{{ $errors->first('not_in') }}						  
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
