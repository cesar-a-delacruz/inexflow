<?php

namespace App\Database\Seeds;

use App\Entities\MeasureUnit;
use CodeIgniter\Database\Seeder;
use App\Models\MeasureUnitModel;

class MeasureUnitsSeeder extends Seeder
{
    public function run()
    {
        $model = new MeasureUnitModel();
        $data = [
            new MeasureUnit(['id' => null, 'value' => 'lb']),
            new MeasureUnit(['id' => null, 'value' => 'kg']),
            new MeasureUnit(['id' => null, 'value' => 'unidad']),
            new MeasureUnit(['id' => null, 'value' => 'paquete']),
            new MeasureUnit(['id' => null, 'value' => 'kg']),
            new MeasureUnit(['id' => null, 'value' => 'hora']),
            new MeasureUnit(['id' => null, 'value' => 'minuto']),
            new MeasureUnit(['id' => null, 'value' => 'segundo']),
            new MeasureUnit(['id' => null, 'value' => 'lt']),
        ];
        foreach ($data as $item) {
            $model->insert($item);
        }
    }
}
