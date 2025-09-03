<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabla estado_asesoria
        Schema::create('estado_asesoria', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->timestamps();
        });




        // Tabla tipo_asesoria
        Schema::create('modo_asesoria', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100); // Ej: Presencial, Virtual
            $table->timestamps();
        });




        // Tabla tipo_asesoria
        Schema::create('tipo_asesoria', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100); // Ej: Presencial, Virtual
            $table->timestamps();
        });






        // Tabla asesoria
        Schema::create('asesoria', function (Blueprint $table) {
            $table->id();
            $table->text('descripcion'); // textarea
            $table->date('fecha');
            $table->time('hora');
            $table->text('enlace')->nullable();
            // Llaves foráneas
            $table->unsignedBigInteger('estado_asesoria_id');
            $table->unsignedBigInteger('modo_asesoria_id');
            $table->unsignedBigInteger('tipo_asesoria_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('estado_asesoria_id')
                ->references('id')
                ->on('estado_asesoria')
                ->restrictOnDelete();

            $table->foreign('tipo_asesoria_id')
                ->references('id')
                ->on('tipo_asesoria')
                ->restrictOnDelete();

            $table->foreign('modo_asesoria_id')
                ->references('id')
                ->on('modo_asesoria')
                ->restrictOnDelete();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->restrictOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asesoria');
        Schema::dropIfExists('tipo_asesoria');
        Schema::dropIfExists('modo_asesoria');
        Schema::dropIfExists('estado_asesoria');
    }
};
