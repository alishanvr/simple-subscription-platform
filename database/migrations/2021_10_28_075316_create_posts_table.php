<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->default(0);
            $table->bigInteger('site_id')->default(0);
            $table->string('slug')->unique();
            $table->string('status')->default('published');
            $table->boolean('is_password_protected')->default(0);
            $table->string('password')->nullable()->default(null);
            $table->string('title');
            $table->text('description')->nullable()->default('');
            $table->string('short_description')->nullable()->default(null);
            $table->string('featured_image')->nullable()->default(null);
            $table->bigInteger('tag_id')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
