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
			{{ Form::form()
				->action(route('movies.filter'))
				->method('GET')
				->open() }}

				{{-- ================= MOVIE POSSESSION STATE ================= --}}
				<div class="form-group">

					{{-- Default --}}
					<div class="form-check">
						{{ html()->input('radio', 'possession_state')->attribute('value', '')->attribute('id', 'stateDefault')->attribute('class', 'form-check-input')->attribute('checked', 'checked') }}
						{{ html()->label(__('app.movie_possession_state_default'))->for('stateDefault')->attribute('class', 'form-check-label') }}
					</div>

					{{-- Own --}}
					<div class="form-check">
						{{ html()->input('radio', 'possession_state')->attribute('value', 'own')->attribute('id', 'stateOwn')->attribute('class', 'form-check-input')->attributeIf(old('possession_state') === 'own', 'checked', 'checked') }}
						{{ html()->label(__('app.movie_possession_state_own'))->for('stateOwn')->attribute('class', 'form-check-label') }}
					</div>

					{{-- To own --}}
					<div class="form-check">
						{{ html()->input('radio', 'possession_state')->attribute('value', 'to_own')->attribute('id', 'stateToOwn')->attribute('class', 'form-check-input')->attributeIf(old('possession_state') === 'to_own', 'checked', 'checked') }}
						{{ html()->label(__('app.movie_possession_state_to_own'))->for('stateToOwn')->attribute('class', 'form-check-label') }}
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
						{{ html()->input('radio', 'rating')->attribute('value', '')->attribute('id', 'ratingDoNotKnow')->attribute('class', 'form-check-input')->attribute('checked', 'checked') }}
						{{ html()->label(__('app.movie_rating_do_not_know'))->for('ratingDoNotKnow')->attribute('class', 'form-check-label') }}
					</div>

					{{-- Fantastic --}}
					<div class="form-check">
						{{ html()->input('radio', 'rating')->attribute('value', 'fantastic')->attribute('id', 'ratingFantastic')->attribute('class', 'form-check-input')->attributeIf(old('rating') === 'fantastic', 'checked', 'checked') }}
						{{ html()->label(__('app.movie_rating_fantastic'))->for('ratingFantastic')->attribute('class', 'form-check-label') }}
					</div>

					{{-- Bad --}}
					<div class="form-check">
						{{ html()->input('radio', 'rating')->attribute('value', 'bad')->attribute('id', 'ratingBad')->attribute('class', 'form-check-input')->attributeIf(old('rating') === 'bad', 'checked', 'checked') }}
						{{ html()->label(__('app.movie_rating_bad'))->for('ratingBad')->attribute('class', 'form-check-label') }}
					</div>

					@if($errors->has('rating'))
						<small class="form-text text-danger">
    						{{ $errors->first('rating') }}
						</small>
					@endif
				</div>

				{{-- ================= MOVIE SEE STATUS ================= --}}
				<div class="form-group">
					{{-- Not criterias --}}
					<div class="form-check">
						{{ html()->input('radio', 'seen')->attribute('value', '')->attribute('id', 'seen-or-unseen')->attribute('class', 'form-check-input')->attribute('checked', 'checked') }}
						{{ html()->label(__('app.default'))->for('seen-or-unseen') }}
					</div>

					{{-- Seen --}}
					<div class="form-check">
						{{ html()->input('radio', 'seen')->attribute('value', 1)->attribute('id', 'seen')->attribute('class', 'form-check-input') }}
						{{ html()->label(__('app.movie_seen'))->for('seen') }}
					</div>

					{{-- Unseen --}}
					<div class="form-check">
						{{ html()->input('radio', 'seen')->attribute('value', 0)->attribute('id', 'unseen')->attribute('class', 'form-check-input') }}
						{{ html()->label(__('app.movie_unseen'))->for('unseen') }}
					</div>

					@if($errors->has('seen'))
						<small id="passwordHelpBlock" class="form-text text-danger">
    						{{ $errors->first('seen') }}
						</small>
					@endif
				</div>

				{{-- ================= MOVIE TYPE ================= --}}
				<div class="form-group">
					{{ html()->label(__('app.movie_type'))->for('type')->attribute('aria-describedby', 'typesHelp') }}
					<small id="typesHelp" class="form-text text-muted">{{ __('app.movie_type_helper') }}</small>
					{{ html()->input('text', 'type')->attribute('value', old('type') ?: null)->attribute('class', 'form-control') }}

					@if($errors->has('type'))
						<small class="form-text text-danger">
    						{{ $errors->first('type') }}
						</small>
					@endif
				</div>

				{{-- ================= MOVIE DIRECTOR ================= --}}
				<div class="form-group">
					{{ html()->label(__('app.movie_director'))->for('director') }}
					{{ html()->input('text', 'director')->attribute('value', old('director') ?: null)->attribute('class', 'form-control') }}

					@if($errors->has('director'))
						<small class="form-text text-danger">
    						{{ $errors->first('director') }}
						</small>
					@endif
				</div>

				{{-- ================= MOVIE STARTING LETTER ================= --}}
				<div class="form-group">
					{{ html()->label(__('app.first_letter'))->for('first_letter') }}
					{{ html()->input('text', 'first_letter')->attribute('value', old('first_letter') ?: null)->attribute('class', 'form-control') }}

					@if($errors->has('first_letter'))
						<small class="form-text text-danger">
    						{{ $errors->first('first_letter') }}
						</small>
					@endif
				</div>

				{{-- ================= ORDER BY ================= --}}
				<div class="form-group">
					{{ html()->label(__('app.order_by'))->for('order_by') }}
					{{ html()->select('order_by')->options([
						'created_at' => __('app.creation_date'),
						'title' => __('app.title')
					])->value(old('order_by') ?: null)->attribute('class', 'form-control') }}

					@if($errors->has('order_by'))
						<small class="form-text text-danger">
    						{{ $errors->first('order_by') }}
						</small>
					@endif
				</div>

				{{-- ================= ORDER ================= --}}
				<div class="form-group">
					{{ html()->label(__('app.order'))->for('order') }}
					{{ html()->select('order')->options([
						'ASC' => __('app.asc'),
						'DESC' => __('app.desc')
					])->value(old('order') ?: null)->attribute('class', 'form-control') }}

					@if($errors->has('order'))
						<small class="form-text text-danger">
    						{{ $errors->first('order') }}
						</small>
					@endif
				</div>

				{{-- ================= PAGE NUMBER ================= --}}
				<div class="form-group">
					{{ html()->label(__('app.page'))->for('page') }}
					{{ html()->input('text', 'page')->attribute('value', old('page') ?: null)->attribute('class', 'form-control') }}

					@if($errors->has('page'))
						<small class="form-text text-danger">
    						{{ $errors->first('page') }}
						</small>
					@endif
				</div>

				{{-- ================= NUMBER ================= --}}
				<div class="form-group">
					{{ html()->label(__('app.number'))->for('number') }}
					{{ html()->input('number', 'number')->attribute('value', old('number') ?: null)->attribute('class', 'form-control') }}

					@if($errors->has('number'))
						<small class="form-text text-danger">
    						{{ $errors->first('number') }}
						</small>
					@endif
				</div>

				{{-- ================= NOT IN ================= --}}
				<div class="form-group">
					{{ html()->label(__('app.not_in'))->for('not_in')->attribute('aria-describedby', 'notInHelp') }}
					<small id="notInHelp" class="form-text text-muted">{{ __('app.not_in_helper') }}</small>
					{{ html()->input('text', 'not_in[]')->attribute('value', old('not_in') ?: null)->attribute('class', 'form-control') }}

					@if($errors->has('not_in'))
						<small class="form-text text-danger">
    						{{ $errors->first('not_in') }}
						</small>
					@endif
				</div>

				{{-- ================= MOVIE RANDOM ================= --}}
				<div class="form-group">

					<div class="form-check">
						{{ html()->input('checkbox', 'random')->attribute('value', true)->attribute('id', 'random')->attribute('class', 'form-check-input')->attributeIf(old('random') ?: false, 'checked', 'checked') }}
						{{ html()->label(__('app.random'))->for('random')->attribute('class', 'form-check-label') }}
					</div>

				</div>

				{{-- ================= FORM SUBMIT ================= --}}
				<a href="{{ route('movies.index') }}" class="btn btn-secondary">
					{{ __('app.cancel') }}
				</a>
				{{ html()->input('submit', null)->attribute('value', __('app.save'))->attribute('class', 'btn btn-primary') }}

			{{ Form::form()->close() }}
		</div>
	</div>
</div>
@endsection
