<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificacion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asesoria_id');
            $table->unsignedBigInteger('user_id');
            $table->string('mensaje', 500);
            $table->date('fecha');
            $table->string('archivo', 100)->nullable();
            $table->boolean('leido')->default(false);
            $table->timestamps();

            // Relaciones
            $table->foreign('asesoria_id')
                ->references('id')
                ->on('asesoria')
                ->onDelete('restrict');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificacion');
    }
};
