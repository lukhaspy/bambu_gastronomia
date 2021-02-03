<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBranchesTable extends Migration{

    public function up(){
        Schema::create('user_branches', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('branch_id');
            $table->primary(['user_id', 'branch_id']);
        });
    }

    public function down(){
        Schema::dropIfExists('user_branches');
    }
}
