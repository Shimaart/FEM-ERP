<?php

use App\Models\Comment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author_id')->nullable();
            $table->morphs('commentable');
            $table->string('type', 16)->default(Comment::TYPE_ACTION);
            $table->string('status')->nullable();
            $table->text('comment')->nullable();
            $table->json('data')->nullable();
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('users');
        });
    }

    /**3
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
