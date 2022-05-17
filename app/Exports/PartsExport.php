<?php

namespace App\Exports;

use App\Models\Part;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PartsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Part::all();
    }

    public function headings(): array
    {
        return ["id", "sku", "part_no_customer","part_no_aji","part_name","model","customer_id","category","cycle_time","addresing","color_id","line_id","packaging_id","updated_by","created_at","updated_at"] ;								
    }
}
