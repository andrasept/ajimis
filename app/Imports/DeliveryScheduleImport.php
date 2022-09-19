<?php

namespace App\Imports;

use App\Models\Delivery;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Date;

class DeliveryScheduleImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        return new Delivery([
            'customer_pickup_id' => $row['customer_pickup_id'],
            'cycle' => $row['cycle'],
            'arrival_plan' =>date("Y-m-d h:i:s", strtotime($row['arrival_plan'])),
            'departure_plan' =>date("Y-m-d h:i:s", strtotime($row['departure_plan'])),
            'vendor' => $row['vendor'],
        ]);

    }
}
