@extends('layouts.app')

@section('title', 'Contact Page')

@section('content')
<h1>contact page</h1>

@can('home.secret')
<p><a href={{ route('home.secret') }}>special link</a></p>
@endcan
@endsection