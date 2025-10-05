<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogosSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('modo_asesoria')->insert([
            [
                'nombre' => 'Presencial',
                'costo' => 0.01,
                'activo' => 1
            ],
            [
                'nombre' => 'Virtual',
                'costo' => 0.02,
                'activo' => 1
            ],
            [
                'nombre' => 'Empresarial',
                'costo' => 0.03,
                'activo' => 1
            ],
        ]);


        DB::table('tipo_pago')->insert([
            ['nombre' => 'Sin detalle de pago', 'activo' => 1],
            ['nombre' => 'Ultimo dia de mes', 'activo' => 1],
            ['nombre' => 'Mensual', 'activo' => 1],
            //['nombre' => 'Quincenal', 'activo' => 1],
            ['nombre' => 'Trimestral', 'activo' => 1],
            ['nombre' => 'Al finalizar', 'activo' => 1],
            ['nombre' => 'Según avance', 'activo' => 1],
        ]);


          DB::table('estado_contrato')->insert([
            ['nombre' => 'Registrado'],
            ['nombre' => 'Finalizado'],
            ['nombre' => 'Anulado'],
        ]);
    }
}
