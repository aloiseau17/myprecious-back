@extends('layouts.app')

@section('content')
<div class="container">
	
	<div class="row">
		<div class="col-12">
			<h1>@lang('app.user_options')</h1>
		</div>
	</div>

	
	<div class="row">
		<div class="col-12">
			{!! Form::open([
				'url' => route('user-option.update'),
				'method' => 'PATCH',
			]) !!}

				{{-- ================= USER LIST ORDER ================= --}}
				<div class="form-group">
					{{ Form::label('list_order', __('app.user_options_list_order')) }}
					{{ Form::select('list_order', [
							'ASC' => __('app.asc'),
							'DESC' => __('app.desc')
						], old('list_order'), [
						'class' => 'form-control'
					]) }}

					@if($errors->has('list_order'))
						<small id="passwordHelpBlock" class="form-text text-danger">
    						{{ $errors->first('list_order') }}						  
						</small>
					@endif
				</div>

				{{-- ================= USER LIST ORDER BY ================= --}}
				<div class="form-group">
					{{ Form::label('list_order_by', __('app.user_options_list_order_by')) }}
					{{ Form::select('list_order_by', [
							'created_at' => __('app.creation_date'),
							'title' => __('app.title'),
						], old('list_order_by'), [
						'class' => 'form-control'
					]) }}

					@if($errors->has('list_order_by'))
						<small id="passwordHelpBlock" class="form-text text-danger">
    						{{ $errors->first('list_order_by') }}						  
						</small>
					@endif
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