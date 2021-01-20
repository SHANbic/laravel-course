@forelse($comments as $comment)
<p class="mb-0 font-size-md">{{ $comment->content }}</p>
@updated(['date' => $comment->created_at, 'name' => $comment->user->name, 'userId' => $comment->user->id])
@endupdated
@empty
<p>No comments yet !</p>
@endforelse