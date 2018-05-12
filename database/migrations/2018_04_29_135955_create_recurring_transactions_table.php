<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecurringTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recurring_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->decimal('amount');
            $table->dateTime('start_on');
            $table->integer('repeat_increment');
            $table->string('repeat_type');
            $table->integer('num_repeats');
            $table->dateTime('end_on')->nullable();
            $table->integer('user_id');
            $table->integer('bank_account_id');
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
        Schema::dropIfExists('recurring_transactions');
    }
}
