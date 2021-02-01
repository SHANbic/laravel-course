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
    @updated(['date' => $post->created_at, 'name' => $post->user->name, 'userId' => $post->user->id])
    @endupdated

    @tags(['tags' => $post->tags])@endtags

    {{ trans_choice('messages.comments', $post->comments_count) }}

    <div class="mb-5">
      @auth
      @can('update', $post)
      <form class="d-inline" action="{{ route('posts.edit', ['post' => $post->id]) }}" method='GET'>
        @csrf
        <input type="submit" value="Edit" class="btn btn-primary">
      </form>
      @endcan
      @endauth
      @auth
      @if(!$post->trashed())
      @can('delete', $post)
      <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method='POST'>
        @csrf
        @method('DELETE')
        <input type="submit" value="Delete" class="btn btn-danger">
      </form>
      @endcan
      @endif
      @endauth

    </div>
    @empty
    <div>the list is empty</div>
    @endforelse
  </div>

  <div class="col-4">
    @include('posts._activity')
  </div>

</div>
@endsection