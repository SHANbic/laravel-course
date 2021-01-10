@extends('layout')

@section('title', 'Contact Page')

@section('content')
<h1>contact page</h1>

@can('secret')
<p><a href={{ route('secret') }}>special link</a></p>
@endcan
@endsection