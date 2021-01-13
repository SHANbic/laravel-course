<?php

use App\Tag;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = collect(['science', 'sports', 'politics', 'economy', 'gaming']);

        $tags->each(function($tagName) {
            $tag = new Tag();
            $tag->name = $tagName;
            $tag->save();
        });

    }
}
