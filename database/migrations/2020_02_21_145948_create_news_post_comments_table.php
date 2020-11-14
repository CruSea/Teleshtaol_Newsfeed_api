<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsPostCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_post_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('comment');
            $table->unsignedBigInteger('news_post_id')->require();
            $table->unsignedBigInteger('user_id')->require();
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
        Schema::dropIfExists('news_post_comments');
    }
}
