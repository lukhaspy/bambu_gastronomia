<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTableMigration extends Migration{

    public function up(){
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedtinyInteger('type')->default(0);
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('product_category_id');
            $table->unsignedDecimal('price', 10, 0);
            $table->unsignedInteger('stock')->default(0);
            $table->unsignedInteger('reserved_stock')->default(0);
            $table->unsignedInteger('unity')->default(0);
            $table->tinyInteger('branch_id')->unsigned()->default(1);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(){
        Schema::dropIfExists('products');
    }
}
