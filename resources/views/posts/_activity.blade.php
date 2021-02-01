<div class="container">
  <div class="row" style='width:100%;'>
    @card(['title' => __('Most Commented') ])
    @slot('subtitle')
    {{__('What people are currently talking about')}}
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
    @card(['title' => __('Most Active') ])
    @slot('subtitle')
    {{__('Writers with most posts written')}}
    @endslot
    @slot('items', collect($most_active)->pluck('name'))
    @endcard
  </div>

  <div class="row mt-4" style='width:100%;'>
    @card(['title' => __('Most active last month') ])
    @slot('subtitle')
    {{__('Users with most posts written in the month')}}
    @endslot
    @slot('items', collect($most_active_last_month)->pluck('name'))
    @endcard
  </div>

</div>