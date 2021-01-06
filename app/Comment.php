<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
    
    public function blogPost()
    {
        // return $this->belongsTo('App\BlogPost', 'post_id', 'blogpost_id');
        // 2nd argument is optional other name for foreign key, 3rd argument is optional other name for primary key
        return $this->belongsTo('App\BlogPost');
    }
}
