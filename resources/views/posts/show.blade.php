@extends('layouts.app')

@section('title', $post['title'])

@section('content')

@if($post['is_new'])
<div>a new blog post</div>
@else(!$post['is_new'])
<div>blog post is old
@endif

@unless($post['is_new'])
<div>it is an old post</div>
@endunless

<h1>{{ $post['title'] }}</h1>
<p>{{ $post['content'] }}</p>

@isset($post['has_comments'])
<div>the post has some comments</div>
@endisset

@endsection