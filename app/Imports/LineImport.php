<?php

namespace App\Imports;

use App\Models\Line;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LineImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Line([
            'line_code' => $row['line_code'],
            'line_name' => $row['line_name'],
            'line_category' => $row['line_category'],
            'tonase' => $row['tonase']
        ]);
    }
}
