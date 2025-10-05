<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contrato', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_contrato');
            $table->unsignedBigInteger('empresa_id');
            $table->unsignedBigInteger('oficina_id');
            $table->unsignedBigInteger('tipo_pago_id');
            $table->unsignedBigInteger('estado_contrato_id');
            $table->decimal('monto_contratado', 15, 2);
            $table->decimal('primer_abono', 15, 2)->nullable();
            $table->decimal('pago_minimo', 15, 2)->nullable();
            $table->string('detalle', 255)->nullable();
            $table->integer('numero_cuotas')->nullable();
            $table->unsignedBigInteger('usuario_creador');
            $table->timestamps();

            // Relaciones
            $table->foreign('empresa_id')->references('id')->on('empresa')->onDelete('restrict');
            $table->foreign('oficina_id')->references('id')->on('oficina')->onDelete('restrict');
            $table->foreign('usuario_creador')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('tipo_pago_id')->references('id')->on('tipo_pago')->onDelete('restrict');
            $table->foreign('estado_contrato_id')->references('id')->on('estado_contrato')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contrato');
    }

};
