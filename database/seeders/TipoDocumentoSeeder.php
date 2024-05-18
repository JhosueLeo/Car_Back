<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoDocumento;

class TipoDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoDocumento::firstOrcreate([
            'nombre'=>'DNI',
            'descripcion'=>'Documento Nacional de Identidad'
            
        ]);
        TipoDocumento::firstOrCreate([
            'nombre'=>'RUC',
            'descripcion'=>'Registro Unico Contribuyente'
        ]);
    }
}
