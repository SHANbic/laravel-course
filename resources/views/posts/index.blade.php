@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')
<div class="row">
  <div class="col-8">
    @forelse ($posts as $key => $post)
    @include('posts.partials.post')
    @empty
    <div>the list is empty</div>
    @endforelse
  </div>
  <div class="col-4">
    <div class="container">
      <div class="row" style='width:100%;'>
        <div class="card" style="width: 18rem;">
          <div class="card-body">
            <h5 class="card-title">Most commented</h5>
            <h6 class="card-subtitle mb-2 text-muted">
              What people are currently alking about
            </h6>
          </div>
          <ul class="list-group list-group-flush">
            @foreach ($most_commented as $post)
            <li class="list-group-item">
              <a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
            </li>
            @endforeach
          </ul>
        </div>
      </div>

      <div class="row mt-4" style='width:100%;'>
        <div class="card" style="width: 18rem;">
          <div class="card-body">
            <h5 class="card-title">Most active</h5>
            <h6 class="card-subtitle mb-2 text-muted">
              Users with most posts written
            </h6>
          </div>
          <ul class="list-group list-group-flush">
            @foreach ($most_active as $user)
            <li class="list-group-item">{{ $user->name }}</li>
            @endforeach
          </ul>
        </div>
      </div>

      <div class="row mt-4" style='width:100%;'>
        <div class="card" style="width: 18rem;">
          <div class="card-body">
            <h5 class="card-title">Most active last month</h5>
            <h6 class="card-subtitle mb-2 text-muted">
              Users with most posts written in the last month
            </h6>
          </div>
          <ul class="list-group list-group-flush">
            @foreach ($most_active_last_month as $user)
            <li class="list-group-item">{{ $user->name }}</li>
            @endforeach
          </ul>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection