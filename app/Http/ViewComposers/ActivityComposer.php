<?php

namespace App\Http\ViewComposers;

use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use App\BlogPost;
use App\User;

class ActivityComposer
{
  public function compose(View $view)
  {
    $mostCommented = Cache::tags(['blog-post'])->remember('blog_post_commented', 60, function () {
      return BlogPost::mostCommented()->take(5)->get();
    });

    $mostActive = Cache::remember('users_most_active', 60, function () {
      return User::withMostBlogPosts()->take(5)->get();
    });

    $mostActiveLastMonth = Cache::remember('users_most_active_last_month', 60, function () {
      return User::withMostBlogPostsLastMonth()->take(5)->get();
    });

    $view->with('most_commented', $mostCommented);
    $view->with('most_active', $mostActive);
    $view->with('most_active_last_month', $mostActiveLastMonth);
  }
}
