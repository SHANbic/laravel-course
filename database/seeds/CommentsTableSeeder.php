<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = App\BlogPost::all();
        $users = App\User::all();

        if ($posts->count() === 0 || $users->count() === 0) {
            $this->command->info('Blog posts or users are empty, therefore you cannot add any comment.');
            return;
        }

        $commentsCount = (int)$this->command->ask('How many comments on blog posts do you want?', 150);
        if ($commentsCount >= 100) {
            $this->command->info('Seeding can be quite long, please hold on');
        }

        factory(App\Comment::class, $commentsCount)->make()->each(function ($comment) use ($posts, $users) {
            $comment->commentable_id = $posts->random()->id;
            $comment->commentable_type = 'App\BlogPost';
            $comment->user_id = $users->random()->id;
            $comment->save();
        });

        $userCommentsCount = (int)$this->command->ask('How many comments on users do you want?', 50);

        factory(App\Comment::class, $userCommentsCount)->make()->each(function ($comment) use ($users) {
            $comment->commentable_id = $users->random()->id;
            $comment->commentable_type = 'App\User';
            $comment->user_id = $users->random()->id;
            $comment->save();
        });
    }
}
