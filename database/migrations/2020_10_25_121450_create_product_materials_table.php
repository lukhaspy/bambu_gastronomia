<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductMaterialsTable extends Migration{

    public function up(){
        Schema::create('product_materials', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('product_id');
            $table->unsignedInteger('material_id');
            $table->unsignedTinyInteger('quantity');

            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('product_materials');
    }
}
