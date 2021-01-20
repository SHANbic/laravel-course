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
            if (env('DB_CONNECTION') !== 'mysql_testing') {
                $table->dropForeign(['blog_post_id']);
                $table->dropColumn('blog_post_id');
            }
        });

        Schema::table('comments', function (Blueprint $table) {
            if (env('DB_CONNECTION') !== 'mysql_testing') {
                $table->unsignedInteger('blog_post_id');
                $table->foreign('blog_post_id')
                    ->references('id')
                    ->on('blog_posts')->default(0)
                    ->onDelete('cascade');
            }
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
            if (Schema::hasColumn('comments', 'blog_post_id')) {
                $table->dropForeign(['blog_post_id']);
                $table->dropIfExists('blog_post_id');
            }
        });

        Schema::table('comments', function (Blueprint $table) {
            if (Schema::hasColumn('comments', 'blog_post_id')) {
                $table->unsignedInteger('blog_post_id');
                $table->foreign('blog_post_id')
                    ->references('id')
                    ->on('blog_posts')->default(0);
            }
        });
    }
}
