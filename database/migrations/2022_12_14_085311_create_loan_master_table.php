<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_master', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id');
            $table->string('loan_type');
            $table->decimal('amount',15,2)->defualt(0);
            $table->integer('loan_term');
            $table->date('loan_date');
            $table->enum('status', ['pending', 'approved','paid'])->default('pending');
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
        Schema::dropIfExists('loan_master');
    }
};
