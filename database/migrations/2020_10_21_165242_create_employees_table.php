<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('document_id')->unique()->nullable();
            $table->string('name');
            $table->string('surname')->nullable();
            $table->string('address')->nullable();
            $table->date('birth')->nullable();
            $table->char('genre', 1)->default(1);
            $table->string('phone');
            $table->decimal('salary');
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
        Schema::dropIfExists('employees');
    }
}
