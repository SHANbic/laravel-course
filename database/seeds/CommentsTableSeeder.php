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

        if($posts->count() === 0) {
            $this->command->info('Blog posts are empty, therefore you cannot add any comment.');
            return;
        } 

        $commentsCount = (int)$this->command->ask('How many comments do you want?', 150);

        $users = App\User::all();

        factory(App\Comment::class, $commentsCount)->make()->each(function ($comment) use ($posts, $users) {
            $comment->blog_post_id = $posts->random()->id;
            $comment->user_id = $users->random()->id;
            $comment->save();
        });
    }
}
