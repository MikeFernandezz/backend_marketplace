<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id('id_categoria');
            $table->string('nombre_categoria', 100);
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('categorias');
    }
};
