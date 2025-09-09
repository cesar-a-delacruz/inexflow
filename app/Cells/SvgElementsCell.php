<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class SvgElementsCell extends Cell
{
    public bool|null $edit = null;
    public bool|null $trash = null;
    public bool|null $close = null;
    public bool|null $check = null;
}
