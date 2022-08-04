<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\DeliveryPrepareCustomer;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Imports\DeliveryPrepareCustomerImport;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
    
            $query = DB::table('delivery_delivery');
            
            if (isset($request->status_arrival) ) {
                    
                if ($request->status_arrival == 'all') {
                    # code...
                }else if($request->status_arrival == '-'){
                    $query->where('arrival_status', NULL);
                }else{
                    $query->where('arrival_status',$request->status_arrival);
                }
                
            }
            if (isset($request->status_departure) ) {
                    
                if ($request->status_departure == 'all') {
                    # code...
                }else if($request->status_departure == '-'){
                    $query->where('departure_status',NULL);
                }else{
                    $query->where('departure_status',$request->status_departure);
                }
                
            }
            if (isset($request->customer_pickup_code) ) {

                if ($request->customer_pickup_code == '-') {
                    # code...
                }else {
                    $query->where('customer_pickup_id',$request->customer_pickup_code);
                }
                    
                
            }
            if (isset($request->min) && isset($request->max) ) {
                if (isset($request->status_departure) ) {
                        
                    if ($request->status_departure == 'all') {
                        # code...
                    }else if($request->status_departure == '-'){
                        $query->where('departure_status',NULL);
                    }else{
                        $query->where('departure_status',$request->status_departure);
                    }
                    
                }
                    
                $query->whereBetween('arrival_plan',[date("Y-m-d H:i:s", strtotime($request->min." 00:00:00")), date("Y-m-d H:i:s", strtotime($request->max." 23:59:00"))]);
                
            }

            $query= $query->select('delivery_delivery.*')->get();

            return DataTables::of($query)->toJson();
        }else{

            $customers = DeliveryPrepareCustomer::select('customer_pickup_code')->orderBy('customer_pickup_code', 'asc')->distinct()->get(); 

            return view('delivery.delivery.delivery', compact('customers'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = DeliveryPrepareCustomer::select('*')->orderBy('help_column', 'asc')->get();
        return view('delivery.delivery.delivery_create', compact('customers'));
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

        //    dd($data);

           $validator = Validator::make($data[0], [
               '*.customer_pickup_id' =>['required'],
               '*.cycle' => ['required','regex:/^[0-9.-]/'],
               '*.arrival_plan' => ['required'],
               '*.departure_plan' => ['required'],
               '*.vendor' => ['required']
           ]);
           if ($validator->fails()) {

               $errors = $validator->errors()->all();
               foreach ($errors as $key => $error) {
                   $num =(int)preg_replace('/[^0-9]/', '', $error)+2;
                   $err_message = explode(".",$error)[1];
                   $errors[$key] = "Line (".$num.") $err_message";
               }

               return redirect('/delivery/delivery')->with('fail', "Import Failed! Because:".implode(", ",$errors));
               
           }else{

               DB::beginTransaction();

               try {
                   $proses = collect(head($data))->each(function ($row, $key) {

                           Delivery::create(
                               [
                                   'customer_pickup_id' => $row['customer_pickup_id'],
                                   'cycle' => $row['cycle'],
                                   'arrival_plan' => date("Y-m-d H:i:s", strtotime($row['arrival_plan'])),
                                   'departure_plan' =>date("Y-m-d H:i:s", strtotime($row['departure_plan'])) ,
                                   'vendor' => $row['vendor'],
                               ]
                           );

                   });

                   DB::commit();

               } catch (\Throwable $th) {
                
                    // return $th;
                   DB::rollback();
                   return redirect('/delivery/delivery')->with('fail', "Import Failed! [105]");
               }
                   
               return redirect('/delivery/delivery')->with('success', 'Import Succeed!');

           }
       }
   }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function show(Delivery $delivery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function edit(Delivery $delivery, $id)
    {
        $data = Delivery::FindOrFail($id);
        return view('delivery.delivery.delivery_edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Delivery $delivery)
    {
        $request->merge(['arrival_plan' => date("Y-m-d H:i:s", strtotime($request->date_plan_arrival." ".$request->time_plan_arrival))]);
        $request->merge(['departure_plan' => date("Y-m-d H:i:s", strtotime($request->date_plan_departure." ".$request->time_plan_departure))]);
       
        $validator =  Validator::make($request->all(),[
            'customer_pickup_id' =>[ 'required'],
            'cycle' =>[ 'required'],
            'vendor' =>['required'],
            'date_plan_arrival' => ['required'],
            'time_plan_arrival' => ['required'],
            'arrival_plan' => ['required','date_format:Y-m-d H:i:s'],
            'departure_plan' => ['required','date_format:Y-m-d H:i:s'],
            'date_plan_departure' => ['required'],
            'time_plan_departure' => ['required'],
        ]);

        if ($validator->fails()) {
            
            return redirect()->back()->with("fail","".implode(" ",$validator->errors()->all()) );
        } else {
            $selection = Delivery::find($request->id);
            DB::beginTransaction();
            try {
                $selection->update($request->all());
                DB::commit();

            } catch (\Throwable $th) {
                // throw $th;
                DB::rollback();
                return redirect('/delivery/delivery')->with('fail', "Add Data Delivery Failed! [105]");
            }
            
            return redirect('/delivery/delivery')->with('success', 'Data Delivery '.$request->customer_pickup_id.' Updated!');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Delivery $delivery, $id)
    {
        try {
            $data = Delivery::findOrFail($id);
            $data->delete();
           
            return redirect('/delivery/delivery')->with('success', 'Data Delivery '.$data->customer_pickup_id.' Deleted!');

        } catch (\Throwable $th) {
            // throw $th;
            return redirect('/delivery/delivery')->with("fail","Failed Delete! [105]" );
        }
    }

    public function insert(Delivery $delivery, Request $request)
    {
        $request->merge(['arrival_plan' => date("Y-m-d H:i:s", strtotime($request->date_plan_arrival." ".$request->time_plan_arrival))]);
        $request->merge(['departure_plan' => date("Y-m-d H:i:s", strtotime($request->date_plan_departure." ".$request->time_plan_departure))]);
       
        $validator =  Validator::make($request->all(),[
            'customer_pickup_id' =>[ 'required'],
            'cycle' =>[ 'required'],
            'vendor' =>['required'],
            'date_plan_arrival' => ['required'],
            'time_plan_arrival' => ['required'],
            'arrival_plan' => ['required','date_format:Y-m-d H:i:s'],
            'departure_plan' => ['required','date_format:Y-m-d H:i:s'],
            'date_plan_departure' => ['required'],
            'time_plan_departure' => ['required'],
        ]);

        


        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }else{
            DB::beginTransaction();


            try {
                $request->request->remove('date_plan_departure');
                $request->request->remove('time_plan_departure');
                $request->request->remove('time_plan_arrival');
                $request->request->remove('date_plan_arrival');
                Delivery::create($request->all());
                DB::commit();

                return redirect('/delivery/delivery')->with('success', 'Data Delivery '.$request->customer_pickup_id.' Added!');
            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;

                return redirect('/delivery/delivery')->with('fail', "Add Data Delivery Failed! [105]");
            }
        }
    }

    public function arrival($id)
    {
        $data =Delivery::find($id);
        
        $now =date("Y-m-d H:i:s");

        try {
            //cek status actual vs plan
            $status_name='';
            if ($now < date("Y-m-d H:i:s", strtotime($data->arrival_plan . '-20 minutes'))) {
                # advance
                $data->arrival_status = 3;
                $status_name='advanced';

            } elseif($now >= date("Y-m-d H:i:s", strtotime($data->arrival_plan . '-20 minutes')) && $now <= date("Y-m-d H:i:s", strtotime($data->arrival_plan)) ) {
                # ontime
                $data->arrival_status = 4;
                $status_name='ontime';
                
            }else {
                # delay
                $data->arrival_status = 5;
                $status_name='delayed';
                
            }

            $data->arrival_actual = $now;
            $data->arrival_gap = date_diff(date_create( $data->arrival_plan),date_create( $data->arrival_actual))->format("%d Days %h Hours %i Minutes");
            $data->save();

            $message='<b>======== DELIVERY ARRIVAL ========</b>'.chr(10).chr(10);
            
            $message .= '<b>Delivery Arrival</b> : '.$data->customer_pickup_id.' '.chr(10).'<b>Plan Date</b> :'.date('d-m-Y H:i:s', strtotime($data->arrival_plan)).''.chr(10).'<b>Actual Date</b> :'.date('d-m-Y H:i:s', strtotime($data->arrival_actual)).' '.chr(10).'<b>Status</b>: '.$status_name;

            $this->sendTelegram('-690929411',$message );

            return redirect('/delivery/delivery')->with('success', $data->customer_pickup_id." ".$data->cycle.' Arrived!');

        } catch (\Throwable $th) {
            return redirect('/delivery/delivery')->with('fail', $data->customer_pickup_id." ".$data->cycle.' Failed Update!');
            // throw $th;
        }
    }

    public function departure($id)
    {
        $data =Delivery::find($id);
        
        $now =date("Y-m-d H:i:s");

        try {
            //cek status actual vs plan
            $status_name='';
            if ($now < date("Y-m-d H:i:s", strtotime($data->departure_plan . '-20 minutes'))) {
                # advance
                $data->departure_status = 3;
                $status_name='advanced';

            } elseif($now >= date("Y-m-d H:i:s", strtotime($data->departure_plan . '-20 minutes')) && $now <= date("Y-m-d H:i:s", strtotime($data->departure_plan)) ) {
                # ontime
                $data->departure_status = 4;
                $status_name='ontime';
                
            }else {
                # delay
                $data->departure_status = 5;
                $status_name='delayed';
                
            }

            $data->departure_actual = $now;
            $data->departure_gap = date_diff(date_create( $data->arrival_plan),date_create( $data->arrival_actual))->format("%d Days %h Hours %i Minutes");
            $data->save();

            $message='<b>======== DELIVERY DEPARTURE ========</b>'.chr(10).chr(10);
            
            $message .= '<b>Delivery Departure</b> : '.$data->customer_pickup_id.''.chr(10).'<b>Plan Date</b> :'.date('d-m-Y H:i:s', strtotime($data->departure_plan)).''.chr(10).'<b>Actual Date</b> :'.date('d-m-Y H:i:s', strtotime($data->departure_actual)).' '.chr(10).'<b>Status</b>: '.$status_name;
             
            $this->sendTelegram('-690929411',$message );

            return redirect('/delivery/delivery')->with('success', $data->customer_pickup_id." ".$data->cycle.' Departured!');
        } catch (\Throwable $th) {
            return redirect('/delivery/delivery')->with('fail', $data->customer_pickup_id." ".$data->cycle.' Failed Update!');
            // throw $th;
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
        file_get_contents('https://api.telegram.org/bot'.$token.'/sendMessage?'.http_build_query($params));
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_POST, 0);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // $response = curl_exec ($ch);
        // $err = curl_error($ch); 
        // curl_close ($ch);
    }
}
