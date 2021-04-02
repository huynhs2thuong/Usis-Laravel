<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTranslationFiedToCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_categories', function (Blueprint $table) {
            $table->text('title');
            $table->text('slug');
            $table->longText('description')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('sticky')->default(false);
            $table->string('type')->default('post');
            $table->text('meta');
            $table->text('meta_title');
            $table->text('meta_desc');
            $table->text('meta_keyword');
            $table->text('user_id')->unsigned()->nullable();
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
        Schema::table('tbl_categories', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('slug');
            $table->dropColumn('description');
            $table->dropColumn('active');
            $table->dropColumn('sticky');
            $table->dropColumn('type');
            $table->dropColumn('meta');
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_desc');
            $table->dropColumn('meta_keyword');
            $table->dropColumn('user_id');
        });
    }
}
