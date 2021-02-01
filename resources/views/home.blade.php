@extends('layout')

@section('title', 'Home Page')

@section('content')
<h1>{{__('messages.welcome')}}</h1>

<p>{{ __('messages.example', ['name' => 'Pierre'] ) }}</p>
<p>{{ trans_choice('messages.plural', 0, ["a"=>1]) }}</p>
<p>{{ trans_choice('messages.plural', 1, ["a"=>1]) }}</p>
<p>{{ trans_choice('messages.plural', 2, ["a"=>1]) }}</p>
<p>{{ __('Welcome to Laravel!') }}</p>
<p>{{ __('Hello :name', ["name" => "Pierre"]) }}</p>
@endsection