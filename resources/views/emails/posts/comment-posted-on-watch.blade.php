@component('mail::message')
# Comment was posted on a blog post you are watching

Hi {{ $user->name }}

See what people think about subject that matters to you

@component('mail::button', ['url' => route('posts.show', ['post' => $comment->commentable->id]) ])
View the blog post
@endcomponent

@component('mail::button', ['url' => route('users.show', ['user' => $comment->user->id]) ])
Visit {{ $comment->user->name }} profile
@endcomponent

@component('mail::panel')
{{ $comment->content }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent