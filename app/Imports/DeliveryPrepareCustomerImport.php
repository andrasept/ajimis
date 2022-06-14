<?php

namespace App\Imports;

use App\Models\DeliveryPrepareCustomer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DeliveryPrepareCustomerImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new DeliveryPrepareCustomer([
            'customer_pickup_code' => $row['customer_pickup_code'],
            'cycle' => $row['cycle'],
            'cycle_time_preparation' => $row['ct'],
            'help_column' => $row['help_column'],
            'time_pickup' => $row['time_pickup'],
            'vendor' => $row['vendor'],
        ]);
    }
}
