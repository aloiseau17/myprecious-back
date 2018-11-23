@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="content">
            <div class="title m-b-md">
                {{ config('app.name') }}
            </div>

            <ul class="links">
               <li>
                    <a href="{{ route('movies.create') }}">
                        @lang('app.movie_add')
                    </a>
               </li>
               <li>
                    <a href="{{ route('movies.index') }}">
                        @lang('app.movie_list_seen')
                    </a>
               </li>
            </ul>
        </div>
    <div class="row">
</div>
@endsection
