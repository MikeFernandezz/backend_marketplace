<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('venta_productos', function (Blueprint $table) {
            $table->id('id_venta_producto');
            $table->unsignedBigInteger('id_venta');
            $table->unsignedBigInteger('id');
            $table->decimal('precio_unitario', 10, 2);
            $table->integer('cantidad')->default(1);
            $table->timestamps();
            
            $table->foreign('id_venta')->references('id_venta')->on('ventas')->onDelete('cascade');
            $table->foreign('id')->references('id')->on('productos')->onDelete('cascade');
            
            // Un producto solo puede estar en una venta una vez
            $table->unique(['id_venta', 'id']);
        });
    }

    public function down() {
        Schema::dropIfExists('venta_productos');
    }
};
