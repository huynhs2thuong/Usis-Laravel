<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cid')->unsigned()->nullable();
            $table->integer('cat_id')->unsigned()->nullable();
            $table->string('title');
            $table->string('slug')->unique();
            $table->boolean('active')->default(true);
            $table->boolean('sticky')->default(false);
            $table->text('excerpt');
            $table->text('overview');
            $table->longText('description');
            $table->text('progress');
            $table->text('investor');
            $table->string('address')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->text('img_slide');
            $table->integer('resource_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('resource_id')->references('id')->on('resources')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('projects');
    }
}
