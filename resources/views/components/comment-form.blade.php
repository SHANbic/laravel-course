<div class="mb-2 mt-2">
  @auth
  <form action="{{ $route }}" method="POST">
    @csrf
    <div class="form-group">
      <textarea type="text" class="form-control" name="content">

    </textarea>
    </div>
    <div><input type="submit" value="Add comment" class="btn btn-primary btn-block"></div>
  </form>
  @else
  <a href="{{ route('login') }}">Sign in</a> to post a comment
  @endauth
</div>
<hr>