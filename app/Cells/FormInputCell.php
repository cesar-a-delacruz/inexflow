<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class FormInputCell extends Cell
{
    public string $name = '';
    public string $label = '';
    public string $type = 'text';
    public bool|null $required = null;
    public bool|null $readonly = null;
    public string|int|null|float $default = null;
    public string|null $error = null;
    public string|null $min = null;
    public string|null $max = null;
    public string|null $step = null;
    public string|null $placeholder = null;
    public array|null $list = null;
}
