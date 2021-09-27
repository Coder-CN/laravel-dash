<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_classes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('parent_id')->nullable();
            $table->string('description')->nullable();
            $table->string('picture')->nullable();
            $table->text('pictures')->nullable();
            $table->string('link_url')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('keywords')->nullable();
            $table->boolean('is_show')->default(true);
            $table->integer('sort')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('info_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('class_id');
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('picture')->nullable();
            $table->text('pictures')->nullable();
            $table->string('link_url')->nullable();
            $table->string('keywords')->nullable();
            $table->longText('content')->nullable();
            $table->string('author')->nullable();
            $table->string('source')->nullable();
            $table->integer('views')->default(0);
            $table->boolean('is_show')->default(true);
            $table->integer('sort')->default(0);
            $table->timestamp('release_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('fileables', function (Blueprint $table) {
            $table->integer('file_id');
            $table->integer('fileable_id');
            $table->string('fileable_type');
            $table->string('title');
            $table->text('info')->nullable();
            $table->timestamp('expiration_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fileables');
        Schema::dropIfExists('info_lists');
        Schema::dropIfExists('info_classes');
    }
}
