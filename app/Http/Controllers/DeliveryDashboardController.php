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

    public function all(Request $request){

    // dashborad Delivery Preparation Today
       $data_preparation_dari_table = DB::table('delivery_preparation')->select('help_column','shift','departure_status','departure_plan','arrival_status','arrival_plan', 'cycle','status',db::raw('CONCAT(plan_date_preparation ," " , plan_time_preparation) as plan'),'pic', 'arrival_plan', DB::raw('CONCAT(plan_date_preparation," ",plan_time_preparation) as preparation_plan'), 'departure_status', 'status', 'customer_pickup_id')->whereDate('plan_date_preparation', date('Y-m-d'))->orderBy('customer_pickup_id')->orderBy('departure_plan')->get();
    // dashboard henkaten
        $data_position_1  = DB::table('delivery_henkaten')->select('delivery_henkaten.position','delivery_henkaten.user_id','delivery_henkaten.henkaten_status',
        'delivery_henkaten.date_henkaten','delivery_man_powers.npk','delivery_man_powers.name','delivery_man_powers.photo','delivery_man_powers.title')
        ->leftjoin('delivery_man_powers', 'delivery_man_powers.npk', '=', 'delivery_henkaten.user_id')->where('delivery_henkaten.shift', 'SHIFT 1')->get()
        ;
        $data_position_2  = DB::table('delivery_henkaten')->select('delivery_henkaten.position','delivery_henkaten.user_id','delivery_henkaten.henkaten_status',
        'delivery_henkaten.date_henkaten','delivery_man_powers.npk','delivery_man_powers.name','delivery_man_powers.photo','delivery_man_powers.title')
        ->leftjoin('delivery_man_powers', 'delivery_man_powers.npk', '=', 'delivery_henkaten.user_id')->where('delivery_henkaten.shift', 'SHIFT 2')->get()
        ;

        // dd($data_position);

        // default shift 1
            $data= [];
            $data['photo_delivery_control'] = asset('/image/nouser.png');
            $data['photo_preparation_pulling_1'] = asset('/image/nouser.png');
            $data['photo_preparation_pulling_2'] = asset('/image/nouser.png');
            $data['photo_pulling_oem_2'] = asset('/image/nouser.png');
            $data['photo_packaging_2'] = asset('/image/nouser.png');
            $data['photo_preparation'] = asset('/image/nouser.png');
            $data['photo_packaging_1'] = asset('/image/nouser.png');
            $data['photo_pulling_oem_1'] = asset('/image/nouser.png');
            $data['photo_sparepart'] = asset('/image/nouser.png');

            $data['henkaten_delivery_control']='';
            $data['henkaten_preparation_pulling_1'] = '';
            $data['henkaten_preparation_pulling_2'] = '';
            $data['henkaten_pulling_oem_2'] = '';
            $data['henkaten_packaging_2'] = '';
            $data['henkaten_preparation'] = '';
            $data['henkaten_packaging_1'] = '';
            $data['henkaten_pulling_oem_1'] = '';
            $data['henkaten_sparepart'] = '';

            $data['nama_delivery_control']='';
            $data['nama_preparation_pulling_1'] = '';
            $data['nama_preparation_pulling_2'] = '';
            $data['nama_pulling_oem_2'] = '';
            $data['nama_packaging_2'] = '';
            $data['nama_preparation'] = '';
            $data['nama_packaging_1'] = '';
            $data['nama_pulling_oem_1'] = '';
            $data['nama_sparepart'] = '';
        // default shift 2
            $data2= [];
            $data2['photo_delivery_control'] = asset('/image/nouser.png');
            $data2['photo_preparation_pulling_1'] = asset('/image/nouser.png');
            $data2['photo_preparation_pulling_2'] = asset('/image/nouser.png');
            $data2['photo_pulling_oem_2'] = asset('/image/nouser.png');
            $data2['photo_packaging_2'] = asset('/image/nouser.png');
            $data2['photo_preparation'] = asset('/image/nouser.png');
            $data2['photo_packaging_1'] = asset('/image/nouser.png');
            $data2['photo_pulling_oem_1'] = asset('/image/nouser.png');
            $data2['photo_sparepart'] = asset('/image/nouser.png');

            $data2['henkaten_delivery_control']='';
            $data2['henkaten_preparation_pulling_1'] = '';
            $data2['henkaten_preparation_pulling_2'] = '';
            $data2['henkaten_pulling_oem_2'] = '';
            $data2['henkaten_packaging_2'] = '';
            $data2['henkaten_preparation'] = '';
            $data2['henkaten_packaging_1'] = '';
            $data2['henkaten_pulling_oem_1'] = '';
            $data2['henkaten_sparepart'] = '';

            $data2['nama_delivery_control']='';
            $data2['nama_preparation_pulling_1'] = '';
            $data2['nama_preparation_pulling_2'] = '';
            $data2['nama_pulling_oem_2'] = '';
            $data2['nama_packaging_2'] = '';
            $data2['nama_preparation'] = '';
            $data2['nama_packaging_1'] = '';
            $data2['nama_pulling_oem_1'] = '';
            $data2['nama_sparepart'] = '';
        // foreach data shift 1
            foreach ($data_position_1 as $position) {
                # code...
                if ($position->position == 'delivery_control' && $position->user_id != 'empty') {
                    $data['photo_delivery_control'] = asset('/storage/delivery-manpower-photo/'.$position->photo);
                    $data['nama_delivery_control'] = $position->name;
                    if ($position->henkaten_status == '1') {
                        $data['henkaten_delivery_control'] =asset("/image/henkaten.png");
                    } else if ($position->henkaten_status == '2') {
                        $data['henkaten_delivery_control'] =asset("/image/substitute.png");
                    }else{

                    }
                    
                }
                if ($position->position == 'preparation_pulling_1' && $position->user_id != 'empty') {
                    $data['photo_preparation_pulling_1'] = asset('/storage/delivery-manpower-photo/'.$position->photo);
                    $data['nama_preparation_pulling_1'] = $position->name;
                    if ($position->henkaten_status == '1') {
                        $data['henkaten_preparation_pulling_1'] =asset("/image/henkaten.png");
                    } else if ($position->henkaten_status == '2') {
                        $data['henkaten_preparation_pulling_1'] =asset("/image/substitute.png");
                    }else{

                    }
                } 
                if ($position->position == 'preparation_pulling_2' && $position->user_id != 'empty') {
                    $data['photo_preparation_pulling_2'] = asset('/storage/delivery-manpower-photo/'.$position->photo);
                    $data['nama_preparation_pulling_2'] = $position->name;
                    if ($position->henkaten_status == '1') {
                        $data['henkaten_preparation_pulling_2'] =asset("/image/henkaten.png");
                    }  else if ($position->henkaten_status == '2') {
                        $data['henkaten_preparation_pulling_2'] =asset("/image/substitute.png");
                    }else{

                    }
                } 
                if ($position->position == 'pulling_oem_2' && $position->user_id != 'empty') {
                    $data['photo_pulling_oem_2'] = asset('/storage/delivery-manpower-photo/'.$position->photo);
                    $data['nama_pulling_oem_2'] = $position->name;

                    if ($position->henkaten_status == '1') {
                        $data['henkaten_pulling_oem_2'] =asset("/image/henkaten.png");
                    }  else if ($position->henkaten_status == '2') {
                        $data['henkaten_pulling_oem_2'] =asset("/image/substitute.png");
                    }else{

                    }
                } 
                if ($position->position == 'packaging_2' && $position->user_id != 'empty') {
                    $data['photo_packaging_2'] = asset('/storage/delivery-manpower-photo/'.$position->photo);
                    $data['nama_packaging_2'] = $position->name;

                    if ($position->henkaten_status == '1') {
                        $data['henkaten_packaging_2'] =asset("/image/henkaten.png");
                    }  else if ($position->henkaten_status == '2') {
                        $data['henkaten_packaging_2'] =asset("/image/substitute.png");
                    }else{

                    }
                } 
                if ($position->position == 'preparation' && $position->user_id != 'empty') {
                    $data['photo_preparation'] = asset('/storage/delivery-manpower-photo/'.$position->photo);
                    $data['nama_preparation'] = $position->name;

                    if ($position->henkaten_status == '1') {
                        $data['henkaten_preparation'] =asset("/image/henkaten.png");
                    }  else if ($position->henkaten_status == '2') {
                        $data['henkaten_preparation'] =asset("/image/substitute.png");
                    }else{

                    }
                } 
                if ($position->position == 'packaging_1' && $position->user_id != 'empty') {
                    $data['photo_packaging_1'] = asset('/storage/delivery-manpower-photo/'.$position->photo);
                    $data['nama_packaging_1'] = $position->name;

                    if ($position->henkaten_status == '1') {
                        $data['henkaten_packaging_1'] =asset("/image/henkaten.png");
                    }  else if ($position->henkaten_status == '2') {
                        $data['henkaten_packaging_1'] =asset("/image/substitute.png");
                    }else{

                    }
                } 
                if ($position->position == 'pulling_oem_1' && $position->user_id != 'empty') {
                    $data['photo_pulling_oem_1'] = asset('/storage/delivery-manpower-photo/'.$position->photo);
                    $data['nama_pulling_oem_1'] = $position->name;

                    if ($position->henkaten_status == '1') {
                        $data['henkaten_pulling_oem_1'] =asset("/image/henkaten.png");
                    }  else if ($position->henkaten_status == '2') {
                        $data['henkaten_pulling_oem_1'] =asset("/image/substitute.png");
                    }else{

                    }
                } 
                if ($position->position == 'sparepart' && $position->user_id != 'empty') {
                    $data['photo_sparepart'] = asset('/storage/delivery-manpower-photo/'.$position->photo);
                    $data['nama_sparepart'] = $position->name;

                    if ($position->henkaten_status == '1') {
                        $data['henkaten_sparepart'] =asset("/image/henkaten.png");
                    }  else if ($position->henkaten_status == '2') {
                        $data['henkaten_sparepart'] =asset("/image/substitute.png");
                    }else{

                    }
                } 
                
            }

        // foreach data shift 2
        foreach ($data_position_2 as $position) {
            # code...
            if ($position->position == 'delivery_control' && $position->user_id != 'empty') {
                $data2['photo_delivery_control'] = asset('/storage/delivery-manpower-photo/'.$position->photo);
                $data2['nama_delivery_control'] = $position->name;
                if ($position->henkaten_status == '1') {
                    $data2['henkaten_delivery_control'] =asset("/image/henkaten.png");
                } else if ($position->henkaten_status == '2') {
                    $data2['henkaten_delivery_control'] =asset("/image/substitute.png");
                }else{

                }
                
            }
            if ($position->position == 'preparation_pulling_1' && $position->user_id != 'empty') {
                $data2['photo_preparation_pulling_1'] = asset('/storage/delivery-manpower-photo/'.$position->photo);
                $data2['nama_preparation_pulling_1'] = $position->name;
                if ($position->henkaten_status == '1') {
                    $data2['henkaten_preparation_pulling_1'] =asset("/image/henkaten.png");
                } else if ($position->henkaten_status == '2') {
                    $data2['henkaten_preparation_pulling_1'] =asset("/image/substitute.png");
                }else{

                }
            } 
            if ($position->position == 'preparation_pulling_2' && $position->user_id != 'empty') {
                $data2['photo_preparation_pulling_2'] = asset('/storage/delivery-manpower-photo/'.$position->photo);
                $data2['nama_preparation_pulling_2'] = $position->name;
                if ($position->henkaten_status == '1') {
                    $data2['henkaten_preparation_pulling_2'] =asset("/image/henkaten.png");
                }  else if ($position->henkaten_status == '2') {
                    $data2['henkaten_preparation_pulling_2'] =asset("/image/substitute.png");
                }else{

                }
            } 
            if ($position->position == 'pulling_oem_2' && $position->user_id != 'empty') {
                $data2['photo_pulling_oem_2'] = asset('/storage/delivery-manpower-photo/'.$position->photo);
                $data2['nama_pulling_oem_2'] = $position->name;

                if ($position->henkaten_status == '1') {
                    $data2['henkaten_pulling_oem_2'] =asset("/image/henkaten.png");
                }  else if ($position->henkaten_status == '2') {
                    $data2['henkaten_pulling_oem_2'] =asset("/image/substitute.png");
                }else{

                }
            } 
            if ($position->position == 'packaging_2' && $position->user_id != 'empty') {
                $data2['photo_packaging_2'] = asset('/storage/delivery-manpower-photo/'.$position->photo);
                $data2['nama_packaging_2'] = $position->name;

                if ($position->henkaten_status == '1') {
                    $data2['henkaten_packaging_2'] =asset("/image/henkaten.png");
                }  else if ($position->henkaten_status == '2') {
                    $data2['henkaten_packaging_2'] =asset("/image/substitute.png");
                }else{

                }
            } 
            if ($position->position == 'preparation' && $position->user_id != 'empty') {
                $data2['photo_preparation'] = asset('/storage/delivery-manpower-photo/'.$position->photo);
                $data2['nama_preparation'] = $position->name;

                if ($position->henkaten_status == '1') {
                    $data2['henkaten_preparation'] =asset("/image/henkaten.png");
                }  else if ($position->henkaten_status == '2') {
                    $data2['henkaten_preparation'] =asset("/image/substitute.png");
                }else{

                }
            } 
            if ($position->position == 'packaging_1' && $position->user_id != 'empty') {
                $data2['photo_packaging_1'] = asset('/storage/delivery-manpower-photo/'.$position->photo);
                $data2['nama_packaging_1'] = $position->name;

                if ($position->henkaten_status == '1') {
                    $data2['henkaten_packaging_1'] =asset("/image/henkaten.png");
                }  else if ($position->henkaten_status == '2') {
                    $data2['henkaten_packaging_1'] =asset("/image/substitute.png");
                }else{

                }
            } 
            if ($position->position == 'pulling_oem_1' && $position->user_id != 'empty') {
                $data2['photo_pulling_oem_1'] = asset('/storage/delivery-manpower-photo/'.$position->photo);
                $data2['nama_pulling_oem_1'] = $position->name;

                if ($position->henkaten_status == '1') {
                    $data2['henkaten_pulling_oem_1'] =asset("/image/henkaten.png");
                }  else if ($position->henkaten_status == '2') {
                    $data2['henkaten_pulling_oem_1'] =asset("/image/substitute.png");
                }else{

                }
            } 
            if ($position->position == 'sparepart' && $position->user_id != 'empty') {
                $data2['photo_sparepart'] = asset('/storage/delivery-manpower-photo/'.$position->photo);
                $data2['nama_sparepart'] = $position->name;

                if ($position->henkaten_status == '1') {
                    $data2['henkaten_sparepart'] =asset("/image/henkaten.png");
                }  else if ($position->henkaten_status == '2') {
                    $data2['henkaten_sparepart'] =asset("/image/substitute.png");
                }else{

                }
            } 
            
        }
        // dashboard delivery achievemnt
            $bulan_ini = date('Y-m');
            $awal_bulan_ini =$bulan_ini."-01";
            $akhir_bulan_ini =$bulan_ini."-31";
            $data_achievment = DB::table('delivery_preparation')
                                ->select(
                                    db::raw('DATE_FORMAT(departure_plan, "%Y-%m-%d") as date'),
                                    db::raw(' COUNT(*) as total_cycle_perhari') ,
                                    db::raw('SUM((
                                        CASE 
                                            WHEN departure_status = 5 || departure_status IS NULL THEN 0
                                            ELSE 1
                                        END)) AS total_ok'),
                                    db::raw('SUM(IF(departure_status IS NULL, 1, 0)) as status_null'),
                                    db::raw('SUM(IF(departure_status = 3, 1, 0)) as status_advance'),
                                    db::raw('SUM(IF(departure_status = 4, 1, 0)) as status_ontime'),
                                    db::raw('SUM(IF(departure_status = 5, 1, 0)) as status_delay'),
                                    db::raw('SUM(IF(departure_status = 6, 1, 0)) as status_pending_belum_datang'),
                                    db::raw('SUM(IF(departure_status = 7, 1, 0)) as status_pending_sudah_datang'),
                                    db::raw('(SUM((
                                        CASE 
                                            WHEN departure_status = 5 || departure_status IS NULL THEN 0
                                            ELSE 1
                                        END)) / COUNT(*))*100 as persen')
                                    )
                                ->where('departure_plan','>=', $awal_bulan_ini.' 00:00:00')
                                ->where('departure_plan','<=', $akhir_bulan_ini.' 23:59:00')
                                ->groupBy(db::raw('DATE_FORMAT(departure_plan, "%Y-%m-%d")'))
                                ->get()->toArray(); 

            $data_achievment_persen = [];
            $data_achievment_date = [];

            foreach ($data_achievment as $item) {
                array_push($data_achievment_persen, explode(".",$item->persen )[0]  ) ;
                array_push($data_achievment_date, $item->date ) ;
            }
            // buat bulan
                $tanggal_bulan = [];
                for ($i=1; $i <= 31; $i++) { 
                    $tanggal_bulan[$i-1] ['tgl'] = $i;
                    $tanggal_bulan[$i-1] ['persen'] = 0;
                }
            // update bulan dengan dat database
                for ($i=0; $i < count($data_achievment_date) ; $i++) { 
                    $data_persen = $data_achievment_persen[$i]; 
                    $pos = (int)date("j", strtotime($data_achievment_date[$i]));
                    $tanggal_bulan[$pos-1]['persen'] = $data_persen;
                }

                for ($i=0; $i < count($tanggal_bulan) ; $i++){
                    $pos = $i;
                    $data_achievment_persen [$pos] = $tanggal_bulan[$pos]['persen'];
                    $data_achievment_date [$pos] = $tanggal_bulan[$pos]['tgl'];
                }

            // convert
                $data_achievment_date = json_encode($data_achievment_date);
                $data_achievment_persen = json_encode($data_achievment_persen);
        // dashboard claim
                //ambil data
                $data_claim = DB::table('delivery_claim')
                                    ->select(
                                        'claim_date',
                                        db::raw('SUM(IF(category = "MISS PART", 1, 0)) as miss_part'),
                                        db::raw('SUM(IF(category = "MIX PART", 1, 0)) as mix_part'),
                                        db::raw('SUM(IF(category = "MISS LABEL", 1, 0)) as miss_label'),
                                        db::raw('SUM(IF(category = "MISS QUANTITY", 1, 0)) as miss_quantity'),
                                        )
                                    ->groupBy('claim_date')
                                    ->get()->toArray(); 
                // declare count array tiap category
                $claim_date = [];
                $miss_part = [];
                $mix_part = [];
                $miss_label = [];
                $miss_quantity = [];
                
                // isi sesuai category
                foreach ($data_claim as $key ) {
                    array_push($claim_date, $key->claim_date);
                    array_push($miss_part, $key->miss_part);
                    array_push($mix_part, $key->mix_part);
                    array_push($miss_label, $key->miss_label);
                    array_push($miss_quantity, $key->miss_quantity);
                }

                
                
    
                // convert json
                $claim_date = json_encode($claim_date);
                $miss_part = json_encode($miss_part);
                $mix_part = json_encode( $mix_part);
                $miss_label = json_encode($miss_label);
                $miss_quantity = json_encode($miss_quantity);
           
        return view('delivery.dashboard.dashboard_all', compact('data_preparation_dari_table', 'data', 'data2','data_achievment_date','data_achievment_persen'
                    , 'claim_date', 'miss_part', 'mix_part','miss_label','miss_quantity')); 
    
    
    
    
    
    
    }

    private function is_in_array($array, $key, $key_value){
        $within_array = 'no';
        foreach( $array as $k=>$v ){
          if( is_array($v) ){
              $within_array = is_in_array($v, $key, $key_value);
              if( $within_array == 'yes' ){
                  break;
              }
          } else {
                  if( $v == $key_value && $k == $key ){
                          $within_array = 'yes';
                          break;
                  }
          }
        }
        return $within_array;
  }
}
