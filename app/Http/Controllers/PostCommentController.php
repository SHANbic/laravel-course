<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\Events\CommentPosted;
use App\Http\Requests\StoreComment;
use App\Http\Resources\Comment as CommentResource;

class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }

    public function index(BlogPost $post)
    {
        return CommentResource::collection($post->comments()->with('user')->get());
        // return $post->comments()->with('user')->get();
    }

    public function store(BlogPost $post, StoreComment $request)
    {
        $comment = $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id
        ]);

        // Mail::to($post->user)->send(new CommentPostedMarkdown($comment));P
        // Mail::to($post->user)->queue(new CommentPostedMarkdown($comment));

        event(new CommentPosted($comment));
        
        // $when = now()->addMinutes(1);
        // Mail::to($post->user)->later($when, new CommentPostedMarkdown($comment));

        return redirect()->back()->withStatus('Comment was created !');
    }
}
