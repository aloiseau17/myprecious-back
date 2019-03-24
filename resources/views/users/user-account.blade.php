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
			{!! Form::open([
				'url' => route('user-email.update'),
				'method' => 'PATCH',
			]) !!}

				<h2>{{ __('app.user_update_email') }}</h2>

				{{-- ================= USER EMAIL ================= --}}
				<div class="form-group">
					{{ Form::label('email', __('app.email')) }}
					{{ Form::text('email', old('email'), [
						'class' => 'form-control'
					]) }}

					@if($errors->has('email'))
						<small id="passwordHelpBlock" class="form-text text-danger">
    						{{ $errors->first('email') }}						  
						</small>
					@endif
				</div>

				{{-- ================= FORM SUBMIT ================= --}}
				{{ Form::submit( __('app.save'), [
					'class' => 'btn btn-primary',
				])}}

			{!! Form::close() !!}

			<br>

			{{-- ============================== PASSWORD FORM ============================== --}}
			{!! Form::open([
				'url' => route('user-password.update'),
				'method' => 'PATCH',
			]) !!}

				<h2>{{ __('app.user_update_password') }}</h2>

				{{-- ================= USER OLD PASSWORD ================= --}}
				<div class="form-group">
					{{ Form::label('old_password', __('app.old_password')) }}
					{{ Form::password('old_password', null, [
						'class' => 'form-control'
					]) }}

					@if($errors->has('old_password'))
						<small id="passwordHelpBlock" class="form-text text-danger">
    						{{ $errors->first('old_password') }}						  
						</small>
					@endif
				</div>

				{{-- ================= USER NEW PASSWORD ================= --}}
				<div class="form-group">
					{{ Form::label('password', __('app.new_password')) }}
					{{ Form::password('password', null, [
						'class' => 'form-control'
					]) }}

					@if($errors->has('password'))
						<small id="passwordHelpBlock" class="form-text text-danger">
    						{{ $errors->first('password') }}						  
						</small>
					@endif
				</div>
				
				{{-- ================= USER NEW PASSWORD CONFIRM ================= --}}
				<div class="form-group">
					{{ Form::label('password_confirmation', __('app.confirm_password')) }}
					{{ Form::password('password_confirmation', null, [
						'class' => 'form-control'
					]) }}
				</div>

				{{-- ================= FORM SUBMIT ================= --}}
				{{ Form::submit( __('app.save'), [
					'class' => 'btn btn-primary',
				])}}

			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection