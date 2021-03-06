<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\Events\BlogPostPosted;
use App\Facades\CounterFacade;
use App\Http\Requests\StorePost;
use App\Image;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'store', 'edit', 'destroy', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(
            'posts.index',
            [
                'posts' => BlogPost::latestWithRelations()->get()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this->authorize('posts.create');
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;
        $post = BlogPost::create($validated);


        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails');
            $post->image()->save(Image::make(['path' => $path]));
        }

        event(new BlogPostPosted($post));

        $request->session()->flash('status', 'the blog post was created');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Display the specified resource.
     *@
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blogPost = Cache::tags(['blog-post'])->remember("blog-post-{$id}", 60, function () use ($id) {
            return BlogPost::with('comments', 'tags', 'user', 'comments.user')->findOrFail($id);
        });

        return view('posts.show', [
            'post' => $blogPost,
            'counter' => CounterFacade::increment("blog-post-{$id}", ["blog-post"])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);

        /* if (Gate::denies('update-post', $post)) {
            abort(403, "You can't edit this blogpost");
        } */

        $this->authorize($post);

        return view('posts.edit', ['post' => BlogPost::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        /* if (Gate::denies('update-post', $post)) {
            abort(403, "You can't edit this blogpost");
        } */

        $this->authorize($post);

        $validated = $request->validated();
        $post->fill($validated);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails');

            if ($post->image) {
                Storage::delete($post->image->path);
                $post->image->path = $path;
                $post->image->save();
            } else {
                $post->image()->save(Image::make(['path' => $path]));
            }
        }

        $post->save();

        $request->session()->flash('status', 'Blog Post was updated !');
        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);

        /* if (Gate::denies('delete-post', $post)) {
            abort(403, "You can't delete this blogpost");
        } */

        $this->authorize($post);

        $post->delete();
        session()->flash('status', 'Blog Post was deleted !');
        return redirect()->route('posts.index');
    }
}
