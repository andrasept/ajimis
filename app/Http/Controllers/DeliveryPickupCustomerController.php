<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DeliveryPickupCustomer;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class DeliveryPickupCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
    
            $query = DeliveryPickupCustomer::all();
            

            return DataTables::of($query)->toJson();
        }else{
            return view('delivery.preparation.pickupcustomer.pickupcustomer');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("delivery.preparation.pickupcustomer.pickupcustomer_create");
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
     * @param  \App\Models\DeliveryPickupCustomer  $deliveryPickupCustomer
     * @return \Illuminate\Http\Response
     */
    public function show(DeliveryPickupCustomer $deliveryPickupCustomer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeliveryPickupCustomer  $deliveryPickupCustomer
     * @return \Illuminate\Http\Response
     */
    public function edit(DeliveryPickupCustomer $deliveryPickupCustomer, $id)
    {
        $data = DeliveryPickupCustomer::findOrFail($id);
        return view("delivery.preparation.pickupcustomer.pickupcustomer_edit", compact('data'));
    }

/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DeliveryPickupCustomer  $deliveryPickupCustomer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeliveryPickupCustomer $deliveryPickupCustomer)
    {
        $validator =  Validator::make($request->all(),[
            'customer_pickup_code' =>['required'],
            'cycle' => ['required','regex:/^[0-9.-]/'],
            'cycle_time_preparation' => ['required','regex:/^[0-9.-]/'],
            'help_column' => ['required'],
            'time_pickup' => ['required']
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }else{
            $selection = DeliveryPickupCustomer::find($request->id);
            try {
                $selection->update($request->all());
            } catch (\Throwable $th) {
                // throw $th;
                return redirect('/delivery/pickupcustomer')->with("fail","Failed Update! [105]" );
            }
            return redirect('/delivery/pickupcustomer')->with("success","Packaging ".$request->customer_pickup_code." Updated!" );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeliveryPickupCustomer  $deliveryPickupCustomer
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeliveryPickupCustomer $deliveryPickupCustomer, $id)
    {
        try {
            $data = DeliveryPickupCustomer::findOrFail($id);
            $data->delete();

            return redirect('/delivery/pickupcustomer')->with("success","Data Customer Pickup ".$data->customer_pickup_code." Deleted!" );
        } catch (\Throwable $th) {
            // throw $th;
            return redirect('/delivery/pickupcustomer')->with("fail","Failed Delete! [105]" );
        }
    }

    public function insert(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'customer_pickup_code' =>['required'],
            'cycle' => ['required','regex:/^[0-9.-]/'],
            'cycle_time_preparation' => ['required','regex:/^[0-9.-]/'],
            'help_column' => ['required','unique:delivery_pickup_customer'],
            'time_pickup' => ['required']
        ]);


        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }else{
            DB::beginTransaction();

            try {
                DeliveryPickupCustomer::create($request->all());
                DB::commit();

                return redirect('/delivery/pickupcustomer')->with('success', 'Data Customer Pickup '.$request->customer_pickup_code.' Added!');
            } catch (\Throwable $th) {
                DB::rollback();
                return redirect('/delivery/pickupcustomer')->with('fail', "Add Data Customer Pickup Failed! [105]");
            }
        }
    }
}
