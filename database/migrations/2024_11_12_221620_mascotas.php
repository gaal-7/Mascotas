<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mascotas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255);
            $table->string('especie', 100);
            $table->string('raza', 100)->nullable();
            $table->integer('edad')->nullable();
            $table->decimal('peso', 5, 2)->nullable();
            $table->string('nombre_dueño', 255);
            $table->string('telefono', 15)->nullable();
            $table->string('imagen', 255)->nullable();
            $table->timestamps(); 
            $table->softDeletes(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('mascotas');
    }
};
