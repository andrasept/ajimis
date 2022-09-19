<?php

namespace App\Imports;

use Throwable;
use App\Models\Part;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PartsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Part([
            'sku' => $row['sku'],
            'part_no_customer' => $row['part_no_customer'],
            'part_no_aji' => $row['part_no_aji'],
            'part_name' => $row['part_name'],
            'model' => $row['model'],
            'customer_id' => $row['customer_id'],
            'category' => $row['category'],
            'cycle_time' => $row['cycle_time'],
            'addresing' => $row['addresing'],
            'color_id' => $row['color_id'],
            'line_id' => $row['line_id'],
            'packaging_id' => $row['packaging_id'],
        ]);
    }

    public function rules(): array
    {
        return [
            'sku' => ['required'],
            'part_no_customer' =>  ['required'],
            'part_no_aji' =>  ['required'],
            'part_name' =>  ['required'],
            'model' =>  ['required'],
            'customer_id' =>  ['required'],
            // 'color_id' => ['required'],
            // 'line_id' => ['required'],
            // 'packaging_id' =>  ['required'],
        ];
    }

    

    public function onFailure(Failure ...$failures)
    {
        // Handle the failures how you'd like.
    }
}
