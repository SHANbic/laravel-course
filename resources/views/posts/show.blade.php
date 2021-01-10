@extends('layout')

@section('title', $post->title)

@section('content')
<h1>
  {{ $post->title }}
  @badge(['show'=>(now()->diffInMinutes($post->created_at) < 5)]) New Post ! @endbadge </h1>
    <p>{{ $post->content }}</p>
    @updated(['date' => $post->created_at, 'name' => $post->user->name])
    @endupdated
    @updated(['date' => $post->updated_at])
    Updated
    @endupdated
    <h4>Comments</h4>
    @forelse($post->comments as $comment)
    <p class="mb-0 font-size-md">{{ $comment->content }}</p>
    @updated(['date' => $comment->created_at])
    @endupdated
    @empty
    <p>No comments yet !</p>
    @endforelse
    @endsection('content')