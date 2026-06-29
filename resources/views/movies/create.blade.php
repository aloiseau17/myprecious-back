@extends('layouts.app')

@section('content')
<div class="container">

	<div class="row">
		<div class="col-12">
			<h1>@lang('app.movie_add')</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-12">
			{{ Form::form()
				->action(route('movies.store'))
				->method('POST')
				->acceptsFiles()
				->open() }}

				{{-- ================= MOVIE TITLE ================= --}}
				<div class="form-group">
					{{ html()->label(__('app.movie_title'))->for('title') }}
					{{ html()->input('text', 'title')->attribute('class', 'form-control')->attributeIf(true, 'required') }}

					@if($errors->has('title'))
						<small id="passwordHelpBlock" class="form-text text-danger">
    						{{ $errors->first('title') }}
						</small>
					@endif
				</div>

				{{-- ================= MOVIE DIRECTOR ================= --}}
				<div class="form-group">
					{{ html()->label(__('app.movie_director'))->for('director') }}
					{{ html()->input('text', 'director')->attribute('class', 'form-control') }}

					@if($errors->has('director'))
						<small id="passwordHelpBlock" class="form-text text-danger">
    						{{ $errors->first('director') }}
						</small>
					@endif
				</div>

				{{-- ================= MOVIE ACTOR ================= --}}
				<div class="form-group">
					{{ html()->label(__('app.movie_actor'))->for('actor') }}
					{{ html()->input('text', 'actor')->attribute('class', 'form-control') }}

					@if($errors->has('actor'))
						<small id="passwordHelpBlock" class="form-text text-danger">
    						{{ $errors->first('actor') }}
						</small>
					@endif
				</div>

				{{-- ================= MOVIE DURATION ================= --}}
				<div class="form-group">
					{{ html()->label(__('app.movie_duration'))->for('duration') }}
					{{ html()->input('number', 'duration')->attribute('class', 'form-control') }}

					@if($errors->has('duration'))
						<small id="passwordHelpBlock" class="form-text text-danger">
    						{{ $errors->first('duration') }}
						</small>
					@endif
				</div>

				{{-- ================= MOVIE TYPE ================= --}}
				<div class="form-group">
					{{ html()->label(__('app.movie_type'))->for('types')->attribute('aria-describedby', 'typesHelp') }}
					<small id="typesHelp" class="form-text text-muted">{{ __('app.movie_type_helper') }}</small>
					{{ html()->input('text', 'types')->attribute('class', 'form-control') }}

					@if($errors->has('types'))
						<small id="passwordHelpBlock" class="form-text text-danger">
    						{{ $errors->first('types') }}
						</small>
					@endif
				</div>

				{{-- ================= MOVIE SEE STATUS ================= --}}
				<div class="form-group">
					{{-- Seen --}}
					<div class="form-check">
						{{ html()->input('radio', 'seen')->attribute('value', 1)->attribute('id', 'seen')->attribute('class', 'form-check-input') }}
						{{ html()->label(__('app.movie_seen'))->for('seen') }}
					</div>

					{{-- Unseen --}}
					<div class="form-check">
						{{ html()->input('radio', 'seen')->attribute('value', 0)->attribute('id', 'unseen')->attribute('class', 'form-check-input')->attribute('checked', 'checked') }}
						{{ html()->label(__('app.movie_unseen'))->for('unseen') }}
					</div>

					@if($errors->has('seen'))
						<small id="passwordHelpBlock" class="form-text text-danger">
    						{{ $errors->first('seen') }}
						</small>
					@endif
				</div>

				{{-- ================= MOVIE RATING ================= --}}
				<div class="form-group">

					{{-- Do not know --}}
					<div class="form-check">
						{{ html()->input('radio', 'rating')->attribute('value', 'empty')->attribute('id', 'ratingDoNotKnow')->attribute('class', 'form-check-input')->attribute('checked', 'checked') }}
						{{ html()->label(__('app.movie_rating_do_not_know'))->for('ratingDoNotKnow')->attribute('class', 'form-check-label') }}
					</div>

					{{-- Fantastic --}}
					<div class="form-check">
						{{ html()->input('radio', 'rating')->attribute('value', 'fantastic')->attribute('id', 'ratingFantastic')->attribute('class', 'form-check-input') }}
						{{ html()->label(__('app.movie_rating_fantastic'))->for('ratingFantastic')->attribute('class', 'form-check-label') }}
					</div>

					{{-- Bad --}}
					<div class="form-check">
						{{ html()->input('radio', 'rating')->attribute('value', 'bad')->attribute('id', 'ratingBad')->attribute('class', 'form-check-input') }}
						{{ html()->label(__('app.movie_rating_bad'))->for('ratingBad')->attribute('class', 'form-check-label') }}
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
						{{ html()->input('radio', 'possession_state')->attribute('value', 'empty')->attribute('id', 'stateDefault')->attribute('class', 'form-check-input')->attribute('checked', 'checked') }}
						{{ html()->label(__('app.movie_possession_state_default'))->for('stateDefault')->attribute('class', 'form-check-label') }}
					</div>

					{{-- Own --}}
					<div class="form-check">
						{{ html()->input('radio', 'possession_state')->attribute('value', 'own')->attribute('id', 'stateOwn')->attribute('class', 'form-check-input') }}
						{{ html()->label(__('app.movie_possession_state_own'))->for('stateOwn')->attribute('class', 'form-check-label') }}
					</div>

					{{-- To own --}}
					<div class="form-check">
						{{ html()->input('radio', 'possession_state')->attribute('value', 'to_own')->attribute('id', 'stateToOwn')->attribute('class', 'form-check-input') }}
						{{ html()->label(__('app.movie_possession_state_to_own'))->for('stateToOwn')->attribute('class', 'form-check-label') }}
					</div>

					@if($errors->has('possession_state'))
						<small id="passwordHelpBlock" class="form-text text-danger">
    						{{ $errors->first('possession_state') }}
						</small>
					@endif
				</div>

				{{-- ================= MOVIE IMAGE ================= --}}
				<div class="form-group">
					{{ html()->label(__('app.movie_image'))->for('file') }}
					{{ html()->input('file', 'file')->attribute('class', 'form-control') }}

					@if($errors->has('file'))
						<small id="passwordHelpBlock" class="form-text text-danger">
    						{{ $errors->first('file') }}
						</small>
					@endif
				</div>

				{{-- ================= MOVIE IMAGE URL ================= --}}
				<div class="form-group">
					{{ html()->label(__('app.movie_image_link'))->for('poster_link')->attribute('aria-describedby', 'ImageLinkHelp') }}
					<small id="ImageLinkHelp" class="form-text text-muted">{{ __('app.movie_image_link_helper') }}</small>
					{{ html()->input('text', 'poster_link')->attribute('class', 'form-control') }}

					@if($errors->has('poster_link'))
						<small id="passwordHelpBlock" class="form-text text-danger">
    						{{ $errors->first('poster_link') }}
						</small>
					@endif
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
