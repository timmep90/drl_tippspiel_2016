@extends('layouts.app')

@section('htmlheader_title')
	Home
@endsection


@section('main-content')
	@if(Auth::user()->user_type->value == 0)
		@include('tippspiel.partials.home.guest')
	@else
		@include('tippspiel.partials.home.auth')
	@endif
@endsection
