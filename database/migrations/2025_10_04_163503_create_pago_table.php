<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
    {
        Schema::create('pago', function (Blueprint $table) {
            $table->id();
            $table->integer('numero');
            $table->unsignedBigInteger('contrato_id');
            $table->date('fecha');
            $table->decimal('cantidad', 10, 2);
            $table->unsignedBigInteger('usuario_creador');
            $table->string('observacion', 255)->nullable();
            $table->boolean('finalizado')->default(false);
            $table->timestamps();

            // Relaciones
            $table->foreign('contrato_id')->references('id')->on('contrato')->onDelete('restrict');
            $table->foreign('usuario_creador')->references('id')->on('users')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pago');
    }
};
