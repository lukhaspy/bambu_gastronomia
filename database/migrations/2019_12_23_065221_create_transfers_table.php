<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('sender_method_id');
            $table->unsignedBigInteger('receiver_method_id');
            $table->decimal('sended_amount', 10, 2);
            $table->decimal('received_amount', 10, 2);
            $table->string('reference')->nullable();
            $table->tinyInteger('branch_id')->unsigned()->default(1);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfers');
    }
}
