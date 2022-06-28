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
    protected $status_prepare;
    protected $status_arrival;
    protected $status_departure;
    protected $customer;

    function __construct($from_date,$to_date, $status_prepare, $status_arrival, $status_departure, $customer) {
            $this->from_date = $from_date;
            $this->to_date = $to_date;
            $this->status_prepare = $status_prepare;
            $this->status_arrival = $status_arrival;
            $this->status_departure = $status_departure;
            $this->customer = $customer;
            
            
    }

    public function collection()
    {
        $query =  PreparationDelivery::query();

        if ($this->status_prepare == 'all') {
            //    $query->where('status', );
            } else {
            $query->where('status', $this->status_prepare);
        }
        if ($this->status_arrival == 'all') {
            //    $query->where('status', );
            } else {
            $query->where('arrival_status', $this->status_arrival);
        }
        if ($this->status_departure == 'all') {
            //    $query->where('status', );
            } else {
            $query->where('departure_status', $this->status_departure);
        }
        if ($this->customer == '-') {
            //    $query->where('status', );
            } else {
            $query->where('customer_pickup_id', $this->customer);
        }
        if (isset($this->from_date) && isset($this->to_date)) {
            $query->whereBetween('plan_date_preparation', [$this->from_date, $this->to_date]);
        } else {
            
        }
        return $query->get()->makeHidden(['created_at', 'updated_at','date_delivery','id']);

    }

    public function headings(): array
    {
        return [ "customer", "cycle","cycle time (minutes)","help column","plan time preparation","shift","pic","time hour","date preparation","plan date preparation","start preparation","end preparation","status","prooblem","remark",   "start by","end by", "time preparation (hours)","arrival_plan","arrival_actual","arrival_gap","arrival_status","departure_plan", "departure_actual", "departure_gap", "departure_status", "vendor"] ;								
    }

}
