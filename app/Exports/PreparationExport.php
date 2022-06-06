<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use App\Models\PreparationDelivery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PreparationExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;
    
    protected $from_date;
    protected $to_date;
    protected $status;

    function __construct($from_date,$to_date, $status) {
            $this->from_date = $from_date;
            $this->to_date = $to_date;
            $this->status = $status;
            
            
    }

    public function collection()
    {
        $query =  PreparationDelivery::query();

        if ($this->status == 'all') {
            //    $query->where('status', );
            } else {
            $query->where('status', $this->status);
        }
        if (isset($this->from_date) && isset($this->to_date)) {
            $query->whereBetween('date_delivery', [$this->from_date, $this->to_date]);
        } else {
            
        }
       
        return $query->get();

    }

    public function headings(): array
    {
        return ["id", "customer", "cycle","cycle time","help column","time pickup","shift","pic","time hour","date preparation","date delivery","start preparation","end preparation","status","start by","end by", "time preparation", "created at", "update at"] ;								
    }

}
