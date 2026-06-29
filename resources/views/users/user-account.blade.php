@extends('layouts.app')

@section('content')
<div class="container">

	<div class="row">
		<div class="col-12">
			<h1>@lang('app.user_account')</h1>
			@if (session('status'))
				<div class="col-12">
					<div class=" alert alert-secondary">
						{{ session('status') }}
					</div>
				</div>
			@endif
		</div>
	</div>

	<br>

	<div class="row">
		<div class="col-12">
			{{-- ============================== EMAIL FORM ============================== --}}
			{{ Form::form()
				->action(route('user-email.update'))
				->method('POST')
				->open() }}

				{{ html()->hidden('_method')->value('PATCH') }}

				<h2>{{ __('app.user_update_email') }}</h2>

				{{-- ================= USER EMAIL ================= --}}
				<div class="form-group">
					{{ html()->label(__('app.email'))->for('email') }}
					{{ html()->input('text', 'email')->attribute('value', old('email'))->attribute('class', 'form-control') }}

					@if($errors->has('email'))
						<small id="passwordHelpBlock" class="form-text text-danger">
    						{{ $errors->first('email') }}
						</small>
					@endif
				</div>

				{{-- ================= FORM SUBMIT ================= --}}
				{{ html()->input('submit', null)->attribute('value', __('app.save'))->attribute('class', 'btn btn-primary') }}

			{{ Form::form()->close() }}

			<br>

			{{-- ============================== PASSWORD FORM ============================== --}}
			{{ Form::form()
				->action(route('user-password.update'))
				->method('POST')
				->open() }}

				{{ html()->hidden('_method')->value('PATCH') }}

				<h2>{{ __('app.user_update_password') }}</h2>

				{{-- ================= USER OLD PASSWORD ================= --}}
				<div class="form-group">
					{{ html()->label(__('app.old_password'))->for('old_password') }}
					{{ html()->input('password', 'old_password')->attribute('class', 'form-control') }}

					@if($errors->has('old_password'))
						<small id="passwordHelpBlock" class="form-text text-danger">
    						{{ $errors->first('old_password') }}
						</small>
					@endif
				</div>

				{{-- ================= USER NEW PASSWORD ================= --}}
				<div class="form-group">
					{{ html()->label(__('app.new_password'))->for('password') }}
					{{ html()->input('password', 'password')->attribute('class', 'form-control') }}

					@if($errors->has('password'))
						<small id="passwordHelpBlock" class="form-text text-danger">
    						{{ $errors->first('password') }}
						</small>
					@endif
				</div>

				{{-- ================= USER NEW PASSWORD CONFIRM ================= --}}
				<div class="form-group">
					{{ html()->label(__('app.confirm_password'))->for('password_confirmation') }}
					{{ html()->input('password', 'password_confirmation')->attribute('class', 'form-control') }}
				</div>

				{{-- ================= FORM SUBMIT ================= --}}
				{{ html()->input('submit', null)->attribute('value', __('app.save'))->attribute('class', 'btn btn-primary') }}

			{{ Form::form()->close() }}
		</div>
	</div>
</div>
@endsection
