<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Imports\CustomerImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class DeliveryCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
    
            $query = Customer::all();
            

            return DataTables::of($query)->toJson();
        }else{
            $customers = Customer::all();
            return view('delivery.master.customer.master_customer', compact('customers'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("delivery.master.customer.master_customer_create");
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

            $data = Excel::toArray(new CustomerImport, request()->file('file'));
            $validator = Validator::make($data[0], [
                '*.customer_code' =>['required'],
                '*.customer_name' => ['required'],
                // 'tonase' => ['required']
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                foreach ($errors as $key => $error) {
                    $num =(int)preg_replace('/[^0-9]/', '', $error)+2;
                    $err_message = explode(".",$error)[1];
                    $errors[$key] = "Line (".$num.") $err_message";
                }

                return redirect('/delivery/master-customer')->with('fail', "Export Failed! Because:".implode(", ",$errors));
                
            }else{

                DB::beginTransaction();

                try {
                    $proses = collect(head($data))->each(function ($row, $key) {

                            Customer::updateOrCreate(
                                ['customer_code' => $row['customer_code']],
                                [
                                    'customer_code' => $row['customer_code'],
                                    'customer_name' => $row['customer_name'],
                                ]
                            );
                            
                    });

                    DB::commit();

                } catch (\Throwable $th) {

                    DB::rollback();
                    return redirect('/delivery/master-customer')->with('fail', "Export Failed! [105]");
                }
                    
                return redirect('/delivery/master-customer')->with('success', 'Export Succeed!');

            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer, $id)
    {
        $data = Customer::findOrFail($id);
        return view("delivery.master.customer.master_customer_edit", compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $validator =  Validator::make($request->all(),[
            'customer_code' =>['required'],
            'customer_name' => ['required'],
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }else{
            $selection = Customer::find($request->id);
            try {
                $selection->update($request->all());
            } catch (\Throwable $th) {
                // throw $th;
                return redirect('/delivery/master-customer')->with("fail","Failed Update! [105]" );
            }
            return redirect('/delivery/master-customer')->with("success","Line ".$request->customer_code." Updated!" );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer, $id)
    {
        try {
            $data = Customer::findOrFail($id);
            $data->delete();

            return redirect('/delivery/master-customer')->with("success","Customer ".$data->customer_code." Deleted!" );
        } catch (\Throwable $th) {
            // throw $th;
            return redirect('/delivery/master-customer')->with("fail","Failed Delete! [105]" );
        }
    }

    public function insert(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'customer_code' =>['required'],
            'customer_name' => ['required'],
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }else{
            DB::beginTransaction();

            try {
                Customer::create($request->all());
                DB::commit();

                return redirect('/delivery/master-customer')->with('success', 'Data Customer '.$request->customer_code.' Added!');
            } catch (\Throwable $th) {
                DB::rollback();
                return redirect('/delivery/master-customer')->with('fail', "Add customer Failed! [105]");
            }
        }
    }
}
