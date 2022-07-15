<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeliveryLayoutArea;
use Illuminate\Support\Facades\DB;
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

             $query = DB::table('delivery_henkaten')->select('delivery_henkaten.position','delivery_henkaten.id','delivery_henkaten.user_id','delivery_henkaten.henkaten_status',
            'delivery_henkaten.date_henkaten','delivery_man_powers.npk','delivery_man_powers.name','delivery_man_powers.photo','delivery_man_powers.title')
            ->leftjoin('delivery_man_powers', 'delivery_man_powers.npk', '=', 'delivery_henkaten.user_id')
            ;

            $query= $query->get();

            return DataTables::of($query)->toJson();

        } else {
            $data_position = $query = DB::table('delivery_henkaten')->select('delivery_henkaten.position','delivery_henkaten.user_id','delivery_henkaten.henkaten_status',
            'delivery_henkaten.date_henkaten','delivery_man_powers.npk','delivery_man_powers.name','delivery_man_powers.photo','delivery_man_powers.title')
            ->leftjoin('delivery_man_powers', 'delivery_man_powers.npk', '=', 'delivery_henkaten.user_id')->get()
            ;

            // default
            $data= [];
            $data['photo_admin_delivery'] = asset('/image/nouser.png');
            $data['photo_finish_goods_1'] = asset('/image/nouser.png');
            $data['photo_finish_goods_2'] = asset('/image/nouser.png');
            $data['photo_preparation_1'] = asset('/image/nouser.png');
            $data['photo_preparation_2'] = asset('/image/nouser.png');
            $data['photo_preparation_3'] = asset('/image/nouser.png');
            $data['photo_packaging'] = asset('/image/nouser.png');
            $data['photo_pulling_sparepart'] = asset('/image/nouser.png');
            $data['photo_sparepart'] = asset('/image/nouser.png');

            $data['henkaten_admin_delivery']='';
            $data['henkaten_finish_goods_1'] = '';
            $data['henkaten_finish_goods_2'] = '';
            $data['henkaten_preparation_1'] = '';
            $data['henkaten_preparation_2'] = '';
            $data['henkaten_preparation_3'] = '';
            $data['henkaten_packaging'] = '';
            $data['henkaten_pulling_sparepart'] = '';
            $data['henkaten_sparepart'] = '';

            $data['nama_admin_delivery']='';
            $data['nama_finish_goods_1'] = '';
            $data['nama_finish_goods_2'] = '';
            $data['nama_preparation_1'] = '';
            $data['nama_preparation_2'] = '';
            $data['nama_preparation_3'] = '';
            $data['nama_packaging'] = '';
            $data['nama_pulling_sparepart'] = '';
            $data['nama_sparepart'] = '';

            foreach ($data_position as $position) {
                # code...
                if ($position->position == 'admin_delivery' && $position->user_id != 'empty') {
                    $data['photo_admin_delivery'] = asset('/storage/delivery-manpower-photo/'.$position->photo);
                    $data['nama_admin_delivery'] = $position->name;
                    if ($position->henkaten_status == '1') {
                        $data['henkaten_admin_delivery'] =asset("/image/henkaten.png");
                    } else {
                        # code...
                    }
                    
                }
                if ($position->position == 'finish_goods_1' && $position->user_id != 'empty') {
                    $data['photo_finish_goods_1'] = asset('/storage/delivery-manpower-photo/'.$position->photo);
                    $data['nama_finish_goods_1'] = $position->name;
                    if ($position->henkaten_status == '1') {
                        $data['henkaten_finish_goods_1'] =asset("/image/henkaten.png");
                    } else {
                        # code...
                    }
                } 
                if ($position->position == 'finish_goods_2' && $position->user_id != 'empty') {
                    $data['photo_finish_goods_2'] = asset('/storage/delivery-manpower-photo/'.$position->photo);
                    $data['nama_finish_goods_2'] = $position->name;
                    if ($position->henkaten_status == '1') {
                        $data['henkaten_finish_goods_2'] =asset("/image/henkaten.png");
                    } else {
                        # code...
                    }
                } 
                if ($position->position == 'preparation_1' && $position->user_id != 'empty') {
                    $data['photo_preparation_1'] = asset('/storage/delivery-manpower-photo/'.$position->photo);
                    $data['nama_preparation_1'] = $position->name;

                    if ($position->henkaten_status == '1') {
                        $data['henkaten_preparation_1'] =asset("/image/henkaten.png");
                    } else {
                        # code...
                    }
                } 
                if ($position->position == 'preparation_2' && $position->user_id != 'empty') {
                    $data['photo_preparation_2'] = asset('/storage/delivery-manpower-photo/'.$position->photo);
                    $data['nama_preparation_2'] = $position->name;

                    if ($position->henkaten_status == '1') {
                        $data['henkaten_preparation_2'] =asset("/image/henkaten.png");
                    } else {
                        # code...
                    }
                } 
                if ($position->position == 'preparation_3' && $position->user_id != 'empty') {
                    $data['photo_preparation_3'] = asset('/storage/delivery-manpower-photo/'.$position->photo);
                    $data['nama_preparation_3'] = $position->name;

                    if ($position->henkaten_status == '1') {
                        $data['henkaten_preparation_3'] =asset("/image/henkaten.png");
                    } else {
                        # code...
                    }
                } 
                if ($position->position == 'packaging' && $position->user_id != 'empty') {
                    $data['photo_packaging'] = asset('/storage/delivery-manpower-photo/'.$position->photo);
                    $data['nama_packaging'] = $position->name;

                    if ($position->henkaten_status == '1') {
                        $data['henkaten_packaging'] =asset("/image/henkaten.png");
                    } else {
                        # code...
                    }
                } 
                if ($position->position == 'pulling_sparepart' && $position->user_id != 'empty') {
                    $data['photo_pulling_sparepart'] = asset('/storage/delivery-manpower-photo/'.$position->photo);
                    $data['nama_pulling_sparepart'] = $position->name;

                    if ($position->henkaten_status == '1') {
                        $data['henkaten_pulling_sparepart'] =asset("/image/henkaten.png");
                    } else {
                        # code...
                    }
                } 
                if ($position->position == 'sparepart' && $position->user_id != 'empty') {
                    $data['photo_sparepart'] = asset('/storage/delivery-manpower-photo/'.$position->photo);
                    $data['nama_sparepart'] = $position->name;

                    if ($position->henkaten_status == '1') {
                        $data['henkaten_sparepart'] =asset("/image/henkaten.png");
                    } else {
                    }
                } 
                
            }

            return view('delivery.layout.index', compact('data'));
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mps =  DB::table('delivery_man_powers')->select('npk','name')->get();
        return view('delivery.layout.create', compact('mps'));
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
            'position' =>['required', 'unique:delivery_henkaten'],
            'user_id' => ['required'],
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
                // dd($th);
                DB::rollback();
                // throw $th;
                return redirect('/delivery/layout_area')->with('fail', "Create Position Failed! [105]");

            }
            
           
        }
    }
}
