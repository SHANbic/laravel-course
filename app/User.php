<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    public const LOCALES = [
        'en' => 'English',
        'es' => 'Espanõl',
        'de' => 'Deutsch'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email',
        'email_verified_at',
        'created_at',
        'updated_at',
        'locale',
        'is_admin',
        'api_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function blogPosts()
    {
        return $this->hasMany("App\BlogPost");
    }

    public function comments()
    {
        return $this->hasMany("App\Comment");
    }

    public function commentsOn()
    {
        return $this->morphMany('App\Comment', 'commentable')->latest();
    }

    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }

    public function scopeWithMostBlogPosts(Builder $query)
    {
        return $query->withCount('blogPosts')->orderBy('blog_posts_count', 'DESC');
    }

    public function scopeWithMostBlogPostsLastMonth(Builder $query)
    {
        return $query->withCount(['blogPosts' => function (Builder $query) {
            $query->whereBetween(static::CREATED_AT, [now()->subMonths(1), now()]);
        }])
            ->has('blogPosts', '>=', 3)
            ->orderBy('blog_posts_count', 'DESC');
    }

    public function scopeThatHasCommentedOnPost(Builder $query, BlogPost $post)
    {
        return $query->whereHas('comments', function ($query) use ($post) {
            return $query->where('commentable_id', '=', $post->id)->where('commentable_type', '=', BlogPost::class);
        });
    }

    public function scopeThatIsAnAdmin(Builder $query)
    {
        return $query->where('is_admin', true);
    }
}
