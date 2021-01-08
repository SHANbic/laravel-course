{{-- @break($key === 2) --}}
{{-- @continue($key === 1) --}}
<h3><a href="{{ route('posts.show', ['post' => $post->id]) }}" class="btn-btn-primary">{{ $post->title }}</a></h3>
<p class="text-muted">
  added on {{ $post->created_at->diffForHumans() }}
  by {{ $post->user['name'] }}
</p>
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
  @can('delete', $post)
  <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method='POST'>
    @csrf
    @method('DELETE')
    <input type="submit" value="Delete" class="btn btn-danger">
  </form>
  @endcan

</div>