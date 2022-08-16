<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       if ($request->start != null && $request->end != null) {
       

         // convert date
         $start = date('Y-m-d', strtotime($request->start));
         $end = date('Y-m-d', strtotime($request->end));

         $data = DB::table('delivery_preparation')->select('help_column', 'cycle', 'arrival_plan', 'departure_plan', 'departure_status', 'status', 'customer_pickup_id')->where('departure_plan','>=', $start.' 00:00:00')->where('departure_plan','<=', $end.' 23:59:00')->orderBy('customer_pickup_id')->orderBy('departure_plan')->get();
       } else {
        $data = DB::table('delivery_preparation')->select('help_column', 'cycle', 'arrival_plan', 'departure_plan', 'departure_status', 'status', 'customer_pickup_id')->whereDate('departure_plan', date('y-m-d'))->orderBy('customer_pickup_id')->orderBy('departure_plan')->get();
       }
       
        $data = json_encode($data);
        return view('delivery.dashboard.dashboard_delivery', compact('data'));
    }

    public function preparation()
    {
        $data = DB::table('delivery_preparation')->select('help_column', 'cycle', 'arrival_plan', DB::raw('CONCAT(plan_date_preparation," ",plan_time_preparation) as preparation_plan'), 'departure_status', 'status', 'customer_pickup_id')->whereDate('departure_plan', date('y-m-d'))->orderBy('customer_pickup_id')->orderBy('departure_plan')->get();
        $data = json_encode($data);
        return view('delivery.dashboard.dashboard_delivery', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  claim
    public function claim(Request $request)
    {

        // ketika ada request
        if ($request->start == null || $request->end == null) {
            
             // cari semua category claim
             $category_claim = DB::table('delivery_claim')->select('category')->distinct()->get();
             // declare count array tiap category
             $arr_jenis_count = [];
             // declare array category
             $arr_jenis = [];
             // color
             $color = ['#074a42', '#914f19'];
             // cari jumlah sesuai masing masing cateory
             foreach ($category_claim as $item) {
                 array_push($arr_jenis, $item->category);
                 array_push($arr_jenis_count, $this->cari_count( $item->category));
                 
             }
 
             // convert json
             $arr_jenis_count = json_encode($arr_jenis_count);
             $arr_jenis = json_encode($arr_jenis);
             $arr_color = json_encode($color);
        }else{
            // convert date
            $start = date('Y-m-d', strtotime($request->start));
            $end = date('Y-m-d', strtotime($request->end));

            // dd($start);
            // cari semua category claim
            $category_claim = DB::table('delivery_claim')->select('category')->where('claim_date','>=', $start)->where('claim_date','<=', $end)->distinct()->get();
            // declare count array tiap category
            $arr_jenis_count = [];
            // declare array category
            $arr_jenis = [];
            // color
            $color = ['#074a42', '#914f19'];
            // cari jumlah sesuai masing masing cateory
            foreach ($category_claim as $item) {
                array_push($arr_jenis, $item->category);
                array_push($arr_jenis_count, $this->cari_count_range( $item->category, $start, $end));
                
            }

            // convert json
            $arr_jenis_count = json_encode($arr_jenis_count);
            $arr_jenis = json_encode($arr_jenis);
            $arr_color = json_encode($color);
        }
        
        return view('delivery.dashboard.dashboard_delivery_claim', compact('arr_jenis', 'arr_jenis_count', 'arr_color'));
    }

    public function cari_count($category){
        return DB::table('delivery_claim')->select('qty')->where('category', $category)->count();
    }
    public function cari_count_range($category, $start, $end){
        return DB::table('delivery_claim')->select('qty')->where('category', $category)->where('claim_date','>=', $start)->where('claim_date','<=', $end)->count();
    }
    // akhir claim

    //  henkaten
    public function henkaten(Request $request)
    {

        // ketika ada request
        if ($request->start == null || $request->end == null) {
            
             // cari semua type henkaten
             $category_henkaten = DB::table('delivery_henkaten_detail')->select('type')->where('date_henkaten','>=', date("Y-m-d")." 00:00:00")->where('date_henkaten','<=', date("Y-m-d")." 23:59:00")->distinct()->get();
             // declare count array tiap category
             $arr_jenis_count_henkaten = [];
             // declare array category
             $arr_jenis_henkaten= [];
             // color
             $color = ['#074a42', '#914f19'];
             // cari jumlah sesuai masing masing cateory
             foreach ($category_henkaten as $item) {
                 array_push($arr_jenis_henkaten, $item->type);
                 array_push($arr_jenis_count_henkaten, $this->cari_count_henkaten( $item->type));
                 
             }
 
             // convert json
             $arr_jenis_count_henkaten = json_encode($arr_jenis_count_henkaten);
             $arr_jenis_henkaten = json_encode($arr_jenis_henkaten);
             $arr_color = json_encode($color);
        }else{
            // convert date
            $start = date('Y-m-d', strtotime($request->start));
            $end = date('Y-m-d', strtotime($request->end));

            // dd($start);
            // cari semua category henkaten
            $category_henkaten = DB::table('delivery_henkaten_detail')->select('type')->where('date_henkaten','>=', $start." 00:00:00")->where('date_henkaten','<=', $end." 23:59:00")->distinct()->get();
            // declare count array tiap category
            $arr_jenis_count_henkaten = [];
            // declare array category
            $arr_jenis_henkaten = [];
            // color
            $color = ['#074a42', '#914f19'];
            // cari jumlah sesuai masing masing cateory
            foreach ($category_henkaten as $item) {
                array_push($arr_jenis_henkaten, $item->type);
                array_push($arr_jenis_count_henkaten, $this->cari_count_range_henkaten( $item->type, $start, $end));
                
            }

            // convert json
            $arr_jenis_count_henkaten = json_encode($arr_jenis_count_henkaten);
            $arr_jenis_henkaten = json_encode($arr_jenis_henkaten);
            $arr_color = json_encode($color);
        }
        return view('delivery.dashboard.dashboard_delivery_henkaten', compact('arr_jenis_henkaten', 'arr_jenis_count_henkaten', 'arr_color'));
    }

    public function cari_count_henkaten($type){
        return DB::table('delivery_henkaten_detail')->select('mp_before')->where('type', $type)->count();
    }
    public function cari_count_range_henkaten($type, $start, $end){
        return DB::table('delivery_henkaten_detail')->select('mp_before')->where('type', $type)->where('date_henkaten','>=', $start." 00:00:00")->where('date_henkaten','<=', $end." 23:59:00")->count();
    }
    // akhir henkaten

  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
