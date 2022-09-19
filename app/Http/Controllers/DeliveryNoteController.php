<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\Customer;
use App\Models\DeliveryNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Imports\DeliveryNoteImport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class DeliveryNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
           
            $query = DB::table('delivery_notes');

            $query= $query->select('delivery_notes.*')->get();
            

            return DataTables::of($query)->toJson();
        }else{
           
            return view("delivery.deliverynote.delivery_note");
        }
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::select('*')->orderBy('customer_code', 'asc')->get()->unique('customer_code');
        return view("delivery.deliverynote.create", compact('customers'));
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

            $data = Excel::toArray(new DeliveryNoteImport, request()->file('file'));

            $validator =  Validator::make($data[0],[
                '*.delivery_note' =>['required', 'unique:delivery_notes'],
                '*.customer' => ['required'],
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                foreach ($errors as $key => $error) {
                    $num =(int)preg_replace('/[^0-9]/', '', $error)+2;
                    $err_message = explode(".",$error)[1];
                    $errors[$key] = "Line (".$num.") $err_message";
                }
 
                return redirect('/delivery/delivery_note')->with('fail', "Import Failed! Because:".implode(", ",$errors));
            } else{
                DB::beginTransaction();
                
                try {
                    
                    $proses = collect(head($data))->each(function ($row, $key) {
                        DeliveryNote::create(
                            [
                            'delivery_note' => $row['delivery_note'],
                            'customer' => $row['customer'],
                            ]
                        );
                    });

                    DB::commit();
                        
                    return redirect('/delivery/delivery_note')->with('success', 'Import Succeed!');

                } catch (\Throwable $th) {
                    // throw $th;
                    DB::rollback();
                    return redirect('/delivery/delivery_note')->with('fail', "Import Failed! [105]");
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DeliveryNote  $deliveryNote
     * @return \Illuminate\Http\Response
     */
    public function show(DeliveryNote $deliveryNote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeliveryNote  $deliveryNote
     * @return \Illuminate\Http\Response
     */
    public function edit(DeliveryNote $deliveryNote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DeliveryNote  $deliveryNote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeliveryNote $deliveryNote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeliveryNote  $deliveryNote
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeliveryNote $deliveryNote)
    {
        //
    }

    public function insert(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'customer' =>['required'],
            'delivery_note' => ['required','unique:delivery_notes'],
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }else{
            DB::beginTransaction();

            try {
                DeliveryNote::create($request->all());
                DB::commit();

                return redirect('/delivery/delivery_note')->with('success', 'Delivery Note Added!');
            } catch (\Throwable $th) {
                DB::rollback();
                // throw $th;

                return redirect('/delivery/delivery_note')->with('fail', "Add Delivery Note Failed! [105]");
            }
        }
    }

    public function check(Request $request)
    {
        if ($request->ajax()) {
            // cari dn 
            $data = DeliveryNote::where('delivery_note', $request->dn)->first();
            $now = date("Y-m-d H:i:s");
            if ($data == []) {
                return '404';
            } else {
                // insert out dan in logic
                    if ($data->out == NULL) {
                        $data->out =$now;
                        $data->status ='1';
                        $data->save();
                    } else {
                        $data->in = $now;
                        // hitung hari
                        $start = strtotime(explode(" ",$data->out)[0]);
                        $end = strtotime(explode(" ",$now)[0]);
                        $days_between = ceil(abs($end - $start) / 86400);

                        
                        // check hari
                        if ($days_between <= 3) {
                            $data->status = '2';
                        } else if($days_between > 3){
                            $data->status = '3';
                        }
                        

                        $data->days = $days_between;
                        $data->save();
                    }
                return json_encode($data);
            }
            
            
            


            
            
        } else {
            # code...
        }
        
    }
}
