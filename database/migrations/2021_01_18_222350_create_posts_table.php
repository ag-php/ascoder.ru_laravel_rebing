<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('categoryId');
            $table->string('slug');
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('description');
            $table->longText('text');
            $table->boolean('active')->default(true);
        });

        Schema::table('posts', function (Blueprint $table) {
            $table
                ->foreign('categoryId')
                ->references('id')->on('categories')
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
        Schema::table('posts', function($table){
            $table->dropForeign(['categoryId']);
        });

        Schema::dropIfExists('posts');
    }
}
