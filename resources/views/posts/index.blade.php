@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')
  @forelse ($posts as $key => $post)
    @include('posts.partials.post')
  @empty
  <div>the list is empty</div>
  @endforelse
@endsection