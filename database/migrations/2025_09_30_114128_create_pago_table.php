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
        Schema::create('pago', function (Blueprint $table) {
            $table->id();
            $table->integer('numero');
            $table->unsignedBigInteger('servicio_id');
            $table->date('fecha');
            $table->decimal('cantidad', 10, 2);
            $table->unsignedBigInteger('usuario_creador');
            $table->timestamp('teimestamp')->nullable();

            // Foreign keys con RESTRICT
            $table->foreign('servicio_id')->references('id')->on('servicio')->onDelete('restrict');
            $table->foreign('usuario_creador')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pago');
    }
};
