@extends('layout')

@section('title', 'Blog Posts')

@section('content')
<div class="row">
  <div class="col-8">
    @forelse ($posts as $key => $post)
    {{-- @break($key === 2) --}}
    {{-- @continue($key === 1) --}}

    <h3>
      @if($post->trashed())
      <del>
        @endif
        <a class="{{ $post->trashed() ? 'text-muted' : '' }}" href="{{ route('posts.show', ['post' => $post->id]) }}" class="btn-btn-primary">{{ $post->title }}</a>
        @if($post->trashed())
      </del>
      @endif
    </h3>
    @updated(['date' => $post->created_at, 'name' => $post->user->name])
    @endupdated
    @if($post->comments_count)
    <p>{{ $post->comments_count }} comments</p>
    @else
    <p>No comments yet !</p>
    @endif()
    <div class="mb-5">
      @can('update', $post)
      <form class="d-inline" action="{{ route('posts.edit', ['post' => $post->id]) }}" method='GET'>
        @csrf
        <input type="submit" value="Edit" class="btn btn-primary">
      </form>
      @endcan
      @if(!$post->trashed())
      @can('delete', $post)
      <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method='POST'>
        @csrf
        @method('DELETE')
        <input type="submit" value="Delete" class="btn btn-danger">
      </form>
      @endcan
      @endif

    </div>
    @empty
    <div>the list is empty</div>
    @endforelse
  </div>
  <div class="col-4">
    <div class="container">
      <div class="row" style='width:100%;'>
        @card(['title' => 'Most commented' ])
        @slot('subtitle')
        What people are currently alking about
        @endslot
        @slot('items')
        @foreach ($most_commented as $post)
        <li class="list-group-item">
          <a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
        </li>
        @endforeach
        @endslot
        @endcard
      </div>

      <div class="row mt-4">
        @card(['title' => 'Most active' ])
        @slot('subtitle')
        Users with most posts written
        @endslot
        @slot('items', collect($most_active)->pluck('name'))
        @endcard
      </div>

      <div class="row mt-4" style='width:100%;'>
        @card(['title' => 'Most active last month' ])
        @slot('subtitle')
        Users with most posts written in the last month
        @endslot
        @slot('items', collect($most_active_last_month)->pluck('name'))
        @endcard
      </div>

    </div>
  </div>
</div>
@endsection