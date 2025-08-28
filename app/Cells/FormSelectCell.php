<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class FormSelectCell extends Cell
{
    public string $name = '';
    public string $label = '';
    public bool|null $required = null;
    public bool|null $readonly = null;
    public array $options = [];
    public string $default = '';
    public string|null $onchange = null;
}
