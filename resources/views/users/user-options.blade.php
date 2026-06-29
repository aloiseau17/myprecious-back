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
			{{ Form::form()
				->action(route('user-option.update'))
				->method('POST')
				->open() }}

				{{ html()->hidden('_method')->value('PATCH') }}

				{{-- ================= USER LIST ORDER ================= --}}
				<div class="form-group">
					{{ html()->label(__('app.user_options_list_order'))->for('list_order') }}
					{{ html()->select('list_order')->options([
						'ASC' => __('app.asc'),
						'DESC' => __('app.desc')
					])->value(old('list_order'))->attribute('class', 'form-control') }}

					@if($errors->has('list_order'))
						<small id="passwordHelpBlock" class="form-text text-danger">
    						{{ $errors->first('list_order') }}
						</small>
					@endif
				</div>

				{{-- ================= USER LIST ORDER BY ================= --}}
				<div class="form-group">
					{{ html()->label(__('app.user_options_list_order_by'))->for('list_order_by') }}
					{{ html()->select('list_order_by')->options([
						'created_at' => __('app.creation_date'),
						'title' => __('app.title'),
					])->value(old('list_order_by'))->attribute('class', 'form-control') }}

					@if($errors->has('list_order_by'))
						<small id="passwordHelpBlock" class="form-text text-danger">
    						{{ $errors->first('list_order_by') }}
						</small>
					@endif
				</div>

				{{-- ================= FORM SUBMIT ================= --}}
				{{ html()->input('submit', null)->attribute('value', __('app.save'))->attribute('class', 'btn btn-primary') }}

			{{ Form::form()->close() }}
		</div>
	</div>
</div>
@endsection
