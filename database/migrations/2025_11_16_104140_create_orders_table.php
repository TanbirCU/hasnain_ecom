<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('user_order_id')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('mobile');
            $table->string('district');
            $table->string('upzilla');
            $table->string('union');
            $table->text('extra_address')->nullable();
            $table->decimal('grand_total', 10, 2);
            $table->tinyInteger('status')->default(0); // 0: pending, 1: completed, etc.
            $table->integer('completed')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('orders');
    }
}
