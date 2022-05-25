<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManPowerDelivery;
use Illuminate\Support\Facades\DB;
use App\Models\PreparationDelivery;
use App\Models\DeliveryPickupCustomer;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class DeliveryPreparationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
    
            // $query = PreparationDelivery::all();
             $query = DB::table('delivery_preparation')
                        ->select('id','customer_pickup_id','cycle','cycle_time_preparation','help_column','time_pickup','shift',
                                'pic', 'time_hour','date_preparation','date_delivery','start_preparation', 'end_preparation', 
                                DB::raw(
                                    
                                'IF(
                                    delivery_preparation.start_preparation IS NULL , 
                                        CONCAT(id,"-0"),
                                            IF(
                                                delivery_preparation.end_preparation IS NULL ,
                                                CONCAT(id,"-1"),
                                                CONCAT(id,"-3")
                                            )
                                        
                                ) 
                                as btn_start'

                                )
                                
                                )
                        ->get();
            

            

            return DataTables::of($query)->toJson();
        }else{
            
            return view('delivery.preparation.preparation.preparation_member');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shifts = ManPowerDelivery::get()->unique('shift');
        $customers = DeliveryPickupCustomer::get(); 
        return view("delivery.preparation.preparation.preparation_create", compact('shifts', 'customers'));
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
     * @param  \App\Models\PreparationDelivery  $preparationDelivery
     * @return \Illuminate\Http\Response
     */
    public function show(PreparationDelivery $preparationDelivery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PreparationDelivery  $preparationDelivery
     * @return \Illuminate\Http\Response
     */
    public function edit(PreparationDelivery $preparationDelivery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PreparationDelivery  $preparationDelivery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PreparationDelivery $preparationDelivery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PreparationDelivery  $preparationDelivery
     * @return \Illuminate\Http\Response
     */
    public function destroy(PreparationDelivery $preparationDelivery)
    {
        //
    }

    public function insert(Request $request)
    {
        
        $validator =  Validator::make($request->all(),[
            'date_delivery' =>['required'],
            'customer_pickup_id' =>['required'],
            'cycle' => ['required','regex:/^[0-9.-]/'],
            'cycle_time_preparation' => ['required','regex:/^[0-9.-]/'],
            'help_column' => ['required'],
            'time_pickup' => ['required'],
            'time_hour' => ['required'],
            'shift' => ['required'],
            'pic' => ['required'],
        ]);


        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }else{
            DB::beginTransaction();

            try {
                PreparationDelivery::create($request->all());
                DB::commit();

                return redirect('/delivery/preparation')->with('success', 'Data Preparation '.$request->customer_pickup_id.' Added!');
            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;

                return redirect('/delivery/preparation')->with('fail', "Add Data Preparation Failed! [105]");
            }
        }
    }

    public function getDataPic(Request $request)
    {

        try {
            $pic = ManPowerDelivery::where('shift', '=', $request->shift)->get();
            return $pic = (count($pic) == 0) ? "404": $pic ;
        } catch (\Throwable $th) {
            return '404';
        }
    }
    public function get_data_detail_pickup(Request $request)
    {

        try {
            $data = DeliveryPickupCustomer::where('help_column', $request->help_column)->first();
            return $data ;
        } catch (\Throwable $th) {
            return '404';
        }
    }
    public function start($id)
    {
        $data = PreparationDelivery::find($id);

        $data->start_preparation = date("Y-m-d H:i:s");
        $data->date_preparation = date("Y-m-d");
 
        $data->save();
        return redirect('/delivery/preparation')->with('success', 'Preparation '.$data->help_column.' Started!');
    }
    public function end($id)
    {
        $data = PreparationDelivery::find($id);
        
        $data->end_preparation = date("Y-m-d H:i:s");
        
        $data->save();
        return redirect('/delivery/preparation')->with('success', 'Preparation '.$data->help_column.' Ended!');
    }
}
