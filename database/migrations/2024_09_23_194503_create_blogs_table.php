<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blogcategory_id');
            $table->string('title')->unique();
            $table->string('category')->nullable();
            $table->string('slug')->nullable();
            $table->string('tags')->nullable();
            $table->string('status')->nullable();
            $table->string('image')->nullable();
            $table->string('date')->nullable();
            $table->text('desc')->nullable();
            $table->timestamps();
            $table->foreign('blogcategory_id')->references('id')->on('blog_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
};
