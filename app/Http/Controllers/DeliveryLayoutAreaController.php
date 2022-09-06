<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManPowerDelivery;
use App\Models\DeliveryLayoutArea;
use Illuminate\Support\Facades\DB;
use App\Models\DeliveryHenkatenDetail;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class DeliveryLayoutAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // $query = DB::table('delivery_henkaten');

             $query = DB::table('delivery_henkaten')->select('delivery_henkaten.position as area_position','delivery_henkaten.id','delivery_henkaten.user_id','delivery_henkaten.henkaten_status',
            'delivery_henkaten.date_henkaten','delivery_henkaten.shift','delivery_man_powers.npk','delivery_man_powers.position as real_position','delivery_man_powers.area','delivery_man_powers.name','delivery_man_powers.photo','delivery_man_powers.title')
            ->leftjoin('delivery_man_powers', 'delivery_man_powers.npk', '=', 'delivery_henkaten.user_id')
            ;

            if ($request->shift != '' || $request->shift != NULL ) {
                $query->where('delivery_henkaten.shift', $request->shift);
            }

            $query= $query->get();

            return DataTables::of($query)->toJson();

        } else {
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
            // dd($data);
            return view('delivery.layout.index', compact('data','data2'));
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $area =  DB::table('delivery_man_powers')->select('area')->where('area','!=', '')->get()->unique();
        return view('delivery.layout.create', compact('area'));
    }

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
     * @param  \App\Models\DeliveryLayoutArea  $deliveryLayoutArea
     * @return \Illuminate\Http\Response
     */
    public function show(DeliveryLayoutArea $deliveryLayoutArea)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeliveryLayoutArea  $deliveryLayoutArea
     * @return \Illuminate\Http\Response
     */
    public function edit(DeliveryLayoutArea $deliveryLayoutArea, $id)
    {
        $data = DeliveryLayoutArea::findOrFail($id);
        $mps =  DB::table('delivery_man_powers')->select('npk','name')->get();
        return view('delivery.layout.edit', compact('data','mps'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DeliveryLayoutArea  $deliveryLayoutArea
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeliveryLayoutArea $deliveryLayoutArea)
    {
        if ($request->ajax()) {
            $data = DeliveryLayoutArea::findOrFail($request->id);
           

           



            $data_user = ManPowerDelivery::where('name' ,$request->nama_pengganti)->get();
            $area_user_pengganti = "";
            foreach ($data_user as $key ) {
                $area_user_pengganti = $key->area;
            }
            if ($request->henkaten == '1') {

                $data->henkaten_status = $request->henkaten;



                $data->date_henkaten = date("Y-m-d H:i:s");
                 // telegram
                 $message='<b>======== HENKATEN ========</b>'.chr(10).chr(10); 
                 $message .= 
                 '<b>Man Power</b> : '.$request->nama_pengganti.' '.chr(10).
                 '<b>Default area</b> : '.$area_user_pengganti.' '.chr(10).
                 '<b>Henkaten Date</b> :'. $data->date_henkaten.''.chr(10).
                 '<b>Area</b> :'.$data->position.' '.chr(10);
                //  $this->sendTelegram('-690929411', $message );

                 //  insert henkaten detail / history
                    $history = new DeliveryHenkatenDetail();
                    $history->area =  $data->position;
                    $history->type =  'henkaten';
                    $history->mp_before =  $request->nama_diganti;
                    $history->mp_after =  $request->nama_pengganti;
                    $history->reason_henkaten =  $request->alasan;
                    $history->default_area_mp_after =  $area_user_pengganti;
                    $history->date_henkaten =   $data->date_henkaten;
                    $save = $history->save();

                

                 
                
            }else{
                // ketika pengganti memang default area nya disitu
               if ($data->position == $area_user_pengganti) {
                // update status layout henkaten ke null
                $data->henkaten_status = null;

                // insert history ke detail henkaten dengan type cancel
                $history = new DeliveryHenkatenDetail();
                $history->area =  $data->position;
                $history->type =  'default';
                $history->mp_before =  $request->nama_diganti;
                $history->mp_after =  $request->nama_pengganti;
                $history->reason_henkaten =  $request->alasan;
                $history->default_area_mp_after =  $area_user_pengganti;
                $history->date_henkaten =    date('Y-m-d H:i:s');
                $save_history = $history->save();
               } else {
                   $data->henkaten_status = $request->henkaten;
                   
                // insert history ke detail henkaten dengan type substitute
                 $history = new DeliveryHenkatenDetail();
                 $history->area =  $data->position;
                 $history->type =  'substitute';
                 $history->mp_before =  $request->nama_diganti;
                 $history->mp_after =  $request->nama_pengganti;
                 $history->reason_henkaten =  $request->alasan;
                 $history->default_area_mp_after =  $area_user_pengganti;
                 $history->date_henkaten =   date('Y-m-d H:i:s');
                 $save_history_2 = $history->save();
               }
               
            }
            $data->user_id = $request->pengganti;
            $data->save();
            return $hasil = ($data->save()) ? '1': '0' ;
        } else {
            $validator =  Validator::make($request->all(),[
                'position' =>['required'],
                'user_id' => ['required'],
                'henkaten_status' => ['required'],
            ]);
    
            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator);
            }else{
                
                DB::beginTransaction();
    
                
                // proses db
                try {
    
                    $data = DeliveryLayoutArea::findOrFail($request->id);
                    $data->fill($request->all());
                    if ($request->henkaten_status) {
                        $data->henkaten_status = $request->henkaten_status;
                        $data->date_henkaten = date("Y-m-d H:i:s");
                    }else{
                        $data->henkaten_status = null;
                        $data->date_henkaten = null;
                    }
                    $data->save();
                    DB::commit();
                    return redirect('/delivery/layout_area')->with('success', 'Position Updated!');
                } catch (\Throwable $th) {
                    // dd($th);
                    DB::rollback();
                    // throw $th;
                    return redirect('/delivery/layout_area')->with('fail', "Update Position Failed! [105]");
    
                }
                
               
            }
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeliveryLayoutArea  $deliveryLayoutArea
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeliveryLayoutArea $deliveryLayoutArea, $id)
    {
        try {
            $data = DeliveryLayoutArea::findOrFail($id);
            $data->delete();
           
            return redirect('/delivery/layout_area')->with('success', 'Position Deleted!');
        } catch (\Throwable $th) {
            // throw $th;
            return redirect('/delivery/layout_area')->with("fail","Failed Delete! [105]");
        }
    }

    public function insert(Request $request)
    {

        $validator =  Validator::make($request->all(),[
            'position' =>['required'],
            'user_id' => ['required','unique:delivery_henkaten'],
            'shift' => ['required'],
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }else{
            
            DB::beginTransaction();

            
            // proses db
            try {

                $data = DeliveryLayoutArea::create($request->all());
               
                DB::commit();

                return redirect('/delivery/layout_area')->with('success', 'Position Created!');
            } catch (\Throwable $th) {
                // dd($th->getMessage());
                DB::rollback();
                // throw $th;
                return redirect('/delivery/layout_area')->with('fail', "Create Position Failed! [105]");

            }
            
           
        }
    }

    public function set_default()
    {
         // cari mp default area masing masing shift
         $mp_default_shift_1 =  DB::table('delivery_man_powers')->select('position','name', 'npk','area', 'shift')->where('shift','SHIFT 1')->distinct('area')->get()->toArray();
         $mp_default_shift_2 =  DB::table('delivery_man_powers')->select('position','name', 'npk','area', 'shift')->where('shift','SHIFT 2')->distinct('area')->get()->toArray();
         
        //  filter default area biar tisdak duplikat
            $hasil_shift_1 =[]; 
            $area_shift_1 =[]; 
            $hasil_shift_2 =[]; 
            $area_shift_2 =[]; 

            for ($i=0; $i < count($mp_default_shift_1) ; $i++) { 
                if (!in_array($mp_default_shift_1[$i]->area, $area_shift_1)) {
                    array_push($area_shift_1,$mp_default_shift_1[$i]->area );
                     $hasil_shift_1[$i]['area']=$mp_default_shift_1[$i]->area;
                     $hasil_shift_1[$i]['npk']=$mp_default_shift_1[$i]->npk;
                     $hasil_shift_1[$i]['shift']=$mp_default_shift_1[$i]->shift;
                     $hasil_shift_1[$i]['area']=$mp_default_shift_1[$i]->area;
                }
            }
            for ($i=0; $i < count($mp_default_shift_2) ; $i++) { 
                if (!in_array($mp_default_shift_2[$i]->area, $area_shift_2)) {
                    array_push($area_shift_2,$mp_default_shift_2[$i]->area );
                     $hasil_shift_2[$i]['area']=$mp_default_shift_2[$i]->area;
                     $hasil_shift_2[$i]['npk']=$mp_default_shift_2[$i]->npk;
                     $hasil_shift_2[$i]['shift']=$mp_default_shift_2[$i]->shift;
                     $hasil_shift_2[$i]['area']=$mp_default_shift_2[$i]->area;
                }
            }

            
         DB::beginTransaction();
         try {
            // hapus layout henkaten
                DeliveryLayoutArea::truncate();
            // insert semua masing masing shift tapi tidak dupolikat default area
                $dataset_1=[];
                $dataset_2=[];
                foreach ($hasil_shift_1 as $item) {
                    $dataset_1 =[
                        'position'  => $item['area'],
                        'user_id'    => $item['npk'],
                        'shift'       => $item['shift'],
                    ];
                    DB::table('delivery_henkaten')->insert($dataset_1);
                }
                foreach ($hasil_shift_2 as $item) {
                    $dataset_2 =[
                        'position'  => $item['area'],
                        'user_id'    => $item['npk'],
                        'shift'       => $item['shift'],
                    ];
                    DB::table('delivery_henkaten')->insert($dataset_2);
                }
                DB::commit();

                return redirect('/delivery/layout_area')->with('success', 'Layout Area Default!');

         } catch (\Throwable $th) {
            DB::rollback();
            return redirect('/delivery/layout_area')->with('fail', "Failed! [105]"); 

         }
            
    }

    public function get_mp_with_same_position(Request $request)
    {
        if ($request->ajax()) {


            $layout_area = DeliveryLayoutArea::all();

            $mp_existing_layout_area = [];
            foreach($layout_area as $object)
            {
                $mp_existing_layout_area[] = $object->user_id;
            }
    
            // get data mp yg sesuai position bukan dia dan juga yg tidak ada di layout area
            $data = ManPowerDelivery::where('position', 'like', "%".$request->jenis."%" )->whereNotIn('npk',$mp_existing_layout_area)->where('npk','!=', $request->npk)->get();
            // data full yg bukan ada di sesuai
            $mp_sesuai_position = [];
            foreach($data as $object2)
            {
                $mp_sesuai_position[] = $object2->npk;
            }

            // get all manpower yg bukan dia dan juga yg tidak ada di layout area
            $data_full = DB::table('delivery_man_powers')->select('npk','name')->whereNotIn('npk',$mp_existing_layout_area)->whereNotIn('npk',$mp_sesuai_position)->get();

            // $data_full = ManPowerDelivery::where('npk','!=', $request->npk)->get();
            return json_encode(array('get' => $data, 'all' => $data_full));
        }
        
    }

    public function get_mp_where_area(Request $request)
    {
        if ($request->ajax()) {
            try {
                $pic = ManPowerDelivery::where('area', '=', $request->area)->where('shift', $request->shift)->get();
                return $pic = (count($pic) == 0) ? "404": $pic ;
            } catch (\Throwable $th) {
                return '404';
            }
        }
    }

    public function sendTelegram($chat_id, $text)
    {
        $token ='1488492213:AAFkw2dzki-No0W5tuu8JjAwm0mvg__98BU';
        // ddd($text);
        // $text = urlencode($text);
        $params=[
            'parse_mode'=>'html',
            'chat_id'=>$chat_id, 
            'text'=>$text,
        ];
        // $url = 'https://api.telegram.org/bot'.$token.'/sendMessage/';
        try {
            file_get_contents('https://api.telegram.org/bot'.$token.'/sendMessage?'.http_build_query($params));
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
