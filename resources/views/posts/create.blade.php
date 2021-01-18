@extends('layout')

@section('title', 'Create the post')
@section('content')
<form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
  @csrf
  @include('posts._form')
  <div><input type="submit" value="Create" class="btn btn-primary btn-block"></div>
</form>
@endsection