<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'home.index')->name('home.index');

Route::view('/contact', 'home.contact')->name('home.contact');

$posts = [
    1 => [
        'title' => 'Intro to Laravel',
        'content' => 'This is a short intro to Laravel',
        'is_new' => true,
        'has_comments' => true
    ],
    2 => [
        'title' => 'Intro to PHP',
        'content' => 'This is a short intro to PHP',
        'is_new' => false
    ]
];

Route::get('/posts', function() use ($posts) {
    //dd(request()->all());
    dd((int)request()->query('page', 1));
    return view('posts.index', ['posts' => $posts]);
})->name('posts.index')->middleware('auth');

Route::get('/posts/{id}', function ($id) use ($posts) {
    abort_if(!isset($posts[$id]), 404);
    return view('posts.show', ['post' => $posts[$id]]);
})
//->where(['id'=>'[0-9]+'])
->name('posts.show');

Route::get('/recent-posts/{days_ago?}', function ($daysAgo = 20) {
    return 'Here are the posts from ' . $daysAgo . ' days ago';
})->name('posts.recent.index');

Route::prefix('/fun')->name('fun.')->group(function() use ($posts){
    Route::get('/responses', function() use ($posts) {
        return response($posts, 201)
        ->header('Content-Type', 'application/json')
        ->cookie('MY_COOKIE', 'PIERRE', 360);
    })->name('responses');
    
    Route::get('/redirect', function() {
        return redirect('/contact');
    })->name('redirect');
    
    Route::get('/back', function() {
        return back();
    })->name('back');
    
    Route::get('/named-route', function() {
        return redirect()->route('posts.show', ['id'=>1]);
    })->name('named-route');
    
    Route::get('/away', function() {
        return redirect()->away('https://lovedev.fr');
    })->name('away');
    
    Route::get('/json', function() use ($posts) {
        return response()->json($posts);
    })->name('json');
    
    Route::get('/download', function() {
        return response()->download(public_path('/test.gif'));
    })->name('download');
});