<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function blogPost()
    {
        // return $this->belongsTo('App\BlogPost', 'post_id', 'blog_post_id');
        // 2nd argument is optional other name for foreign key, 3rd argument is optional other name for primary key
        return $this->belongsTo('App\BlogPost');
    }
}
