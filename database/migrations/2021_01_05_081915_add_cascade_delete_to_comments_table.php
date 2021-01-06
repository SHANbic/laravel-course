<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCascadeDeleteToCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            if (env('DB_CONNECTION') !== 'sqlite_testing') {
                $table->dropForeign(['blog_post_id']);
                $table->dropColumn('blog_post_id');
            }
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->foreignId('blog_post_id')
                ->default(0)
                ->constrained()
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['blog_post_id']);
            $table->dropColumn('blog_post_id');
        });
        Schema::table('comments', function (Blueprint $table) {
            $table->foreignId('blog_post_id')
                ->default(0)
                ->constrained();
        });
    }
}
