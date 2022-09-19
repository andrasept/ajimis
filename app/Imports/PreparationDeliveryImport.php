<?php

namespace App\Imports;

use App\Models\PreparationDelivery;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PreparationDeliveryImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new PreparationDelivery([
            'customer_pickup_id' => $row['customer_pickup_id'],
            'cycle' => $row['cycle'],
            'cycle_time_preparation' => $row['cycle_time_preparation'],
            'help_column' => $row['help_column'],
            'plan_time_preparation' =>date("h:i:s", strtotime($row['plan_time_preparation'])),
            'shift' => $row['shift'],
            'pic' => $row['pic'],
            'time_hour' => $row['time_hour'],
            'plan_date_preparation' => date("Y-m-d", strtotime($row['plan_date_preparation'])),
            'arrival_plan' =>date("Y-m-d h:i:s", strtotime($row['arrival_plan'])),
            'departure_plan' =>date("Y-m-d h:i:s", strtotime($row['departure_plan'])),
            'vendor' => $row['vendor'],
        ]);

    }
}
