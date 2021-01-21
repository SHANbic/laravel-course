<?php

namespace App;

use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use App\Traits\Taggable;

class Comment extends Model
{
    use SoftDeletes, Taggable;

    protected $fillable = ['user_id', 'content'];

    public function commentable()
    {
        return $this->morphTo('App\BlogPost');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public static function boot()
    {
        parent::boot();

        // static::addGlobalScope(new LatestScope);
        static::creating(function (Comment $comment) {
            if($comment->commentable_type === BlogPost::class)
            Cache::tags(['blog-post'])->forget("blog-post-{$comment->commentable_id}");
            Cache::tags(['blog-post'])->forget("mostCommented");
        });
    }
}
