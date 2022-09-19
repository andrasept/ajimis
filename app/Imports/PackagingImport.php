<?php

namespace App\Imports;

use App\Models\Packaging;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PackagingImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Packaging([
            'packaging_code' => $row['packaging_code'],
            'qty_per_pallet' => $row['qty_per_pallet']
        ]);
    }
}
