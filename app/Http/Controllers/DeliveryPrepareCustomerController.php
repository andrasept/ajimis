<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\DeliveryPrepareCustomer;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Imports\DeliveryPrepareCustomerImport;

class DeliveryPrepareCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
    
            $query = DeliveryPrepareCustomer::all();
            

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
         // untuk import excel 
         if ($request->hasFile('file')) {

            $data = Excel::toArray(new DeliveryPrepareCustomerImport, request()->file('file'));

            // dd($data);

            $validator = Validator::make($data[0], [
                '*.customer_pickup_code' =>['required'],
                '*.cycle' => ['required','regex:/^[0-9.-]/'],
                '*.cycle_time_preparation' => ['required','regex:/^[0-9.-]/'],
                '*.help_column' => ['required'],
                '*.time_pickup' => ['required'],
                '*.vendor' => ['required']
            ]);
            if ($validator->fails()) {

                $errors = $validator->errors()->all();
                foreach ($errors as $key => $error) {
                    $num =(int)preg_replace('/[^0-9]/', '', $error)+2;
                    $err_message = explode(".",$error)[1];
                    $errors[$key] = "Line (".$num.") $err_message";
                }

                return redirect('/delivery/pickupcustomer')->with('fail', "Import Failed! Because:".implode(", ",$errors));
                
            }else{

                DB::beginTransaction();

                try {
                    $proses = collect(head($data))->each(function ($row, $key) {

                            DeliveryPrepareCustomer::updateOrCreate(
                                ['help_column' => $row['help_column']],
                                [
                                    'customer_pickup_code' => $row['customer_pickup_code'],
                                    'cycle' => $row['cycle'],
                                    'cycle_time_preparation' => $row['cycle_time_preparation'],
                                    'help_column' => $row['help_column'],
                                    'time_pickup' => $row['time_pickup'],
                                    'vendor' => $row['vendor'],
                                ]
                            );
                            
                    });

                    DB::commit();

                } catch (\Throwable $th) {

                    DB::rollback();
                    return redirect('/delivery/pickupcustomer')->with('fail', "Import Failed! [105]");
                }
                    
                return redirect('/delivery/pickupcustomer')->with('success', 'Import Succeed!');

            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DeliveryPrepareCustomer  $DeliveryPrepareCustomer
     * @return \Illuminate\Http\Response
     */
    public function show(DeliveryPrepareCustomer $DeliveryPrepareCustomer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeliveryPrepareCustomer  $DeliveryPrepareCustomer
     * @return \Illuminate\Http\Response
     */
    public function edit(DeliveryPrepareCustomer $DeliveryPrepareCustomer, $id)
    {
        $data = DeliveryPrepareCustomer::findOrFail($id);
        return view("delivery.preparation.pickupcustomer.pickupcustomer_edit", compact('data'));
    }

/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DeliveryPrepareCustomer  $DeliveryPrepareCustomer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeliveryPrepareCustomer $DeliveryPrepareCustomer)
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
            $selection = DeliveryPrepareCustomer::find($request->id);
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
     * @param  \App\Models\DeliveryPrepareCustomer  $DeliveryPrepareCustomer
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeliveryPrepareCustomer $DeliveryPrepareCustomer, $id)
    {
        try {
            $data = DeliveryPrepareCustomer::findOrFail($id);
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
            'time_pickup' => ['required'],
        ]);


        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }else{
            DB::beginTransaction();

            try {
                DeliveryPrepareCustomer::create($request->all());
                DB::commit();

                return redirect('/delivery/pickupcustomer')->with('success', 'Data Customer Pickup '.$request->customer_pickup_code.' Added!');
            } catch (\Throwable $th) {
                return $th;
                // DB::rollback();
                // return redirect('/delivery/pickupcustomer')->with('fail', "Add Data Customer Pickup Failed! [105]");
            }
        }
    }
}
