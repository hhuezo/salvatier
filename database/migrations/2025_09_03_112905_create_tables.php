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
            $table->text('descripcion');
            $table->date('fecha');
            $table->time('hora');
            $table->text('enlace')->nullable();

            $table->decimal('costo_asesoria', 10, 2)->nullable();
            $table->dateTime('fecha_pago')->nullable();
            $table->string('id_trasaccion', 100)->nullable();

            $table->foreignId('abogado_asignado_id')->nullable()->constrained('users')->restrictOnDelete()->restrictOnUpdate();
            $table->foreignId('estado_asesoria_id')->constrained('estado_asesoria')->restrictOnDelete();
            $table->foreignId('tipo_asesoria_id')->constrained('tipo_asesoria')->restrictOnDelete();
            $table->foreignId('modo_asesoria_id')->constrained('modo_asesoria')->restrictOnDelete();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete()->restrictOnUpdate();

            $table->timestamps();
        });


        // Tabla historial asesoria
        Schema::create('asesoria_historial', function (Blueprint $table) {
            $table->id();
            $table->text('descripcion');
            $table->date('fecha');
            $table->time('hora');
            $table->text('enlace')->nullable();
            $table->text('comentario')->nullable();
            $table->foreignId('abogado_asignado_id')->nullable()->constrained('users')->restrictOnDelete()->restrictOnUpdate();
            $table->foreignId('asesoria_id')->constrained('asesoria')->restrictOnDelete();
            $table->foreignId('estado_asesoria_id')->constrained('estado_asesoria')->restrictOnDelete();
            $table->foreignId('tipo_asesoria_id')->constrained('tipo_asesoria')->restrictOnDelete();
            $table->foreignId('modo_asesoria_id')->constrained('modo_asesoria')->restrictOnDelete();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete()->restrictOnUpdate();

            $table->timestamps();
        });



        Schema::create('notificacion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('fecha');
            $table->string('mensaje', 300);
            $table->string('archivo', 150)->nullable();
            $table->integer('criticidad')->default(1);
            $table->integer('activo')->default(1);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->restrictOnDelete()
                ->restrictOnUpdate();
        });


        Schema::create('configuracion', function (Blueprint $table) {
            $table->id();
             $table->decimal('costo_asesoria', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asesoria_historial');
        Schema::dropIfExists('asesoria');
        Schema::dropIfExists('tipo_asesoria');
        Schema::dropIfExists('modo_asesoria');
        Schema::dropIfExists('estado_asesoria');
        Schema::dropIfExists('notificacion');
        Schema::dropIfExists('configuracion');
    }
};
