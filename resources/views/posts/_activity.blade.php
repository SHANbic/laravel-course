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