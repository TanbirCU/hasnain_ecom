<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNavIconsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nav_icons', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->string('icon');
            $table->string('footer_description');
            $table->string('footer_address');
            $table->string('footer_email')->nullable();
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
        Schema::dropIfExists('nav_icons');
    }
}
