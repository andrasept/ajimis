<?php

namespace App\Imports;

use App\Models\DeliveryNote;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DeliveryNoteImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new DeliveryNote([
            'delivery_note' => $row['delivery_note'],
            'customer' => $row['customer'],
        ]);
    }
}
