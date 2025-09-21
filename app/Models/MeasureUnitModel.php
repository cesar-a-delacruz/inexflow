<?php

namespace App\Models;

use App\Entities\MeasureUnit;
use CodeIgniter\Model;
class MeasureUnitModel extends Model
{
    protected $table = 'measure_units';
    /** @var class-string<MeasureUnit> */
    protected $returnType = MeasureUnit::class;
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;

    protected $allowedFields = [
        'id',
        'value',
    ];
}
