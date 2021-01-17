<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersExpertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers_experts', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount',15,2);
            $table->enum('status',['rejected', 'approved', 'pending']);
            $table->unsignedBigInteger('customers_id');
            $table->foreign('customers_id')->references('id')->on('customers')->onDelete('cascade');
            $table->unsignedBigInteger('experts_id');
            $table->foreign('experts_id')->references('id')->on('experts')->onDelete('cascade');
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
        Schema::dropIfExists('customers_experts');
    }
}
