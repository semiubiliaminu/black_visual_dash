<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('end_year');
            $table->string('citylng')->nullable();
            $table->string('citylat')->nullable();
            $table->string('intensity');
            $table->string('sector')->nullable();
            $table->string('topic')->nullable();
            $table->string('insight');
            $table->string('swot');
            $table->string('url');
            $table->string('region');
            $table->string('start_year')->nullable();
            $table->string('impact')->nullable();
            $table->string('added');
            $table->string('published');
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('relevance');
            $table->string('pestle')->nullable();
            $table->string('source')->nullable();
            $table->string('title');
            $table->string('likelihood');
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
        Schema::dropIfExists('news');
    }
}
