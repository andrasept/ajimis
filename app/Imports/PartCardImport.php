<?php

namespace App\Imports;

use App\Models\PartCard;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PartCardImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new PartCard([
            'color_code' => $row['color_code'],
            'description' => $row['description'],
            'remark_1' => $row['remark_pertama'],
            'remark_2' => $row['remark_kedua'],
        ]);
    }
}
