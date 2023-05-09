<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            // $table->id();
            $table->bigInteger('order_id');
            $table->string('order_no');
            $table->bigInteger('user_id')->unsigned();
            $table->string('seminar_day');
            $table->string('seminar_name');
            $table->date('order_use_from');
            $table->date('order_use_to');
            $table->boolean('order_is_finished');
            $table->timestamps();
            $table->primary(['order_id','user_id']);

        });

        Schema::table('orders', function (Blueprint $table) {

            $table->bigIncrements('order_id')->change();

            // 外部キー制約
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
