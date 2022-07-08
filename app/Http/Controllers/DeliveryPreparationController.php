<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManPowerDelivery;
use App\Exports\PreparationExport;
use Illuminate\Support\Facades\DB;
use App\Models\PreparationDelivery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\DeliveryPrepareCustomer;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Imports\PreparationDeliveryImport;

class DeliveryPreparationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->check_delay();
        if ($request->ajax()) {
           
            $query = DB::table('delivery_preparation');

            

            $npk =  auth()->user()->npk;
            if ($request->member == '1') {
                $query->where('pic','=', $npk);
            }else {
                if (isset($request->min) && isset($request->max)) {
                    
                    $query->whereBetween('plan_date_preparation', [date("Y-m-d", strtotime($request->min)), date("Y-m-d", strtotime($request->max))]);
                    
                }

                if (isset($request->help_column) ) {
                    
                    if ($request->help_column == '-') {
                        # code...
                    } else {
                        $query->where('customer_pickup_id',$request->help_column);
                    }
                    
                }

                if(isset($request->status) && $request->status != 'all' ){
                    if ($request->status == "0") {
                        
                        $query->where('status', NULL);
                        
                    } else {

                        $query->where('status',$request->status );
                   
                    }
                    
                }
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
                if ($request->member == '2') {
                    $query->where('departure_status','=', NULL)->whereIn('customer_pickup_id', function($q){
                        $q->select('customer_pickup_id')->where('customer_pickup_id','like', '%AHM%'  )
                        ->orWhere('customer_pickup_id','like', '%TMMIN%'  )
                        ->orWhere('customer_pickup_id','like', '%ADM%'  );
                    });
                }

                
            }

            
           
                $query= $query->select('delivery_preparation.*')->get();
            

            return DataTables::of($query)->toJson();
        }else{
            $customers = DeliveryPrepareCustomer::select('customer_pickup_code')->groupBy('customer_pickup_code')->get(); 
            return view('delivery.preparation.preparation.preparation', compact('customers'));
        }
    }

    public function dashboard()
    {
        $now = date("Y-m-d");
        

        $date_min_3 = date('Y-m-d', strtotime("-6 days"));
        $date_plus_3 = date('Y-m-d', strtotime("+3 days"));
        
       
                            
        $data = [];
        $data['lists'] = PreparationDelivery::where('plan_date_preparation', $now)->orderBy('plan_time_preparation', 'asc')->get();
        $data['total'] = PreparationDelivery::where('plan_date_preparation', $now)->count();
        $data['not_started'] = PreparationDelivery::where('plan_date_preparation', $now)->where('status', NULL)->count();
        $data['on_progress'] = PreparationDelivery::where('plan_date_preparation', $now)->where('status', '1')->count();
        $data['finished'] = PreparationDelivery::where('plan_date_preparation', $now)->where('status','!=', NULL)->where('status','!=', '1')->count();
        $data['ontime'] = PreparationDelivery::where('plan_date_preparation', $now)->where('status','4')->count();
        $data['delay'] = PreparationDelivery::where('plan_date_preparation', $now)->where('status','5')->count();
        $data['advanced'] = PreparationDelivery::where('plan_date_preparation', $now)->where('status','3')->count();
       
        $data_chart['ontime'][] =$data['ontime'];
        $data_chart['delay'][] =$data['delay'];
        $data_chart['advanced'][] =$data['advanced'];
        $data_chart['on_progress'][] =$data['on_progress'];
        $data_chart['not_started'][] =$data['not_started'];
        $data_chart['label'][] =  $now;

        $data['chart'] =  json_encode($data_chart);

        return view("delivery.preparation.preparation.dashboard", compact('data'));
    }

    public function member()
    {
        $data_delay = $this->check_delay();
        return view('delivery.preparation.preparation.preparation_member', compact('data_delay'));
    }

    public function security()
    {
        $customers = DeliveryPrepareCustomer::select('customer_pickup_code')->whereIn('customer_pickup_code', function($q){
            $q->select('customer_pickup_code')->where('customer_pickup_code','like', '%AHM%'  )
            ->orWhere('customer_pickup_code','like', '%TMMIN%'  )
            ->orWhere('customer_pickup_code','like', '%ADM%'  );
        })->groupBy('customer_pickup_code')->get(); 

        return view('delivery.preparation.preparation.preparation_security', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shifts = ManPowerDelivery::select('*')->orderBy('shift', 'asc')->get()->unique('shift');
        $customers = DeliveryPrepareCustomer::select('*')->orderBy('help_column', 'asc')->get(); 
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
        // untuk import excel 
        if ($request->hasFile('file')) {

            $data = Excel::toArray(new PreparationDeliveryImport, request()->file('file'));
            foreach ($data[0] as $key => $value) {
                $data[0][$key] ['date_plan_arrival'] = date("Y-m-d H:i:s", strtotime($data[0][$key] ['date_plan_arrival']));
                $data[0][$key] ['date_plan_departure'] = date("Y-m-d H:i:s", strtotime($data[0][$key] ['date_plan_departure']));
            }

            // dd($data);
            
            $validator =  Validator::make($data[0],[
                // 'date_delivery' =>['required'],
                '*.customer_pickup_id' =>['required'],
                '*.cycle' => ['required','regex:/^[0-9.-]/'],
                '*.cycle_time_preparation' => ['required','regex:/^[0-9.-]/'],
                '*.help_column' => ['required'],
                '*.plan_time_preparation' => ['required'],
                '*.time_hour' => ['required'],
                '*.shift' => ['required'],
                '*.pic' => ['required'],
                '*.plan_date_preparation' => ['required'],

                '*.vendor' =>['required'],
                '*.date_plan_arrival' => ['required','date_format:Y-m-d H:i:s'],
                '*.date_plan_departure' => ['required','date_format:Y-m-d H:i:s'],
            ]);

            if ($validator->fails()) {
 
                $errors = $validator->errors()->all();
                foreach ($errors as $key => $error) {
                    $num =(int)preg_replace('/[^0-9]/', '', $error)+2;
                    $err_message = explode(".",$error)[1];
                    $errors[$key] = "Line (".$num.") $err_message";
                }
 
                return redirect('/delivery/preparation')->with('fail', "Import Failed! Because:".implode(", ",$errors));
                
            }else{
 
                DB::beginTransaction();
 
                try {
                    $proses = collect(head($data))->each(function ($row, $key) {
 
                            PreparationDelivery::create(
                                [
                                    'customer_pickup_id' => $row['customer_pickup_id'],
                                    'cycle' => $row['cycle'],
                                    'cycle_time_preparation' => $row['cycle_time_preparation'],
                                    'help_column' => $row['help_column'],
                                    'plan_time_preparation' => date("H:i:s", strtotime($row['plan_time_preparation'])),
                                    'time_hour' => $row['time_hour'],
                                    'shift' => $row['shift'],
                                    'pic' => $row['pic'],
                                    'plan_date_preparation' =>  date("Y-m-d", strtotime($row['plan_date_preparation'])),
                                    'vendor' =>$row['vendor'],
                                    'arrival_plan' => date("Y-m-d H:i:s", strtotime($row['date_plan_arrival'])),
                                    'departure_plan' =>  date("Y-m-d H:i:s", strtotime($row['date_plan_departure'])),
                                    
                                ]
                            );
 
                    });
 
                    DB::commit();
 
                } catch (\Throwable $th) {
                 
                    //  return $th;
                    DB::rollback();
                    return redirect('/delivery/preparation')->with('fail', "Import Failed! [105]");
                }
                    
                return redirect('/delivery/preparation')->with('success', 'Import Succeed!');
 
            }
        }
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
    public function edit(PreparationDelivery $preparationDelivery, $id)
    {
        $shifts = ManPowerDelivery::get()->unique('shift');
        $customers = DeliveryPrepareCustomer::get(); 
        $data = PreparationDelivery::FindOrFail($id);
        return view('delivery.preparation.preparation.preparation_edit',compact('data','shifts','customers'));
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
        $request->merge(['arrival_plan' => date("Y-m-d H:i:s", strtotime($request->date_plan_arrival." ".$request->time_plan_arrival))]);
        $request->merge(['departure_plan' => date("Y-m-d H:i:s", strtotime($request->date_plan_departure." ".$request->time_plan_departure))]);

        $validator =  Validator::make($request->all(),[
            'plan_date_preparation' =>['required'],
            'customer_pickup_id' =>['required'],
            'cycle' => ['required','regex:/^[0-9.-]/'],
            'cycle_time_preparation' => ['required','regex:/^[0-9.-]/'],
            'help_column' => ['required'],
            'time_hour' => ['required'],
            'shift' => ['required'],
            'pic' => ['required'],

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
            $selection = PreparationDelivery::find($request->id);
            DB::beginTransaction();
            try {
                $selection->update($request->all());
                DB::commit();

            } catch (\Throwable $th) {
                // throw $th;
                DB::rollback();
                return redirect('/delivery/preparation')->with("fail","Failed Update! [105]" );
            }
            
            return redirect('/delivery/preparation')->with('success', 'Schedule '.$request->customer_pickup_id.' Updated!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PreparationDelivery  $preparationDelivery
     * @return \Illuminate\Http\Response
     */
    public function destroy(PreparationDelivery $preparationDelivery, $id)
    {
        try {
            $data = PreparationDelivery::findOrFail($id);
            $data->delete();
           
            return redirect('/delivery/preparation')->with('success', 'Preparation '.$data->help_column.' Deleted!');
        } catch (\Throwable $th) {
            // throw $th;
            return redirect('/delivery/preparation')->with("fail","Failed Delete! [105]" );
        }
    }

    public function insert(Request $request)
    {
        $request->merge(['arrival_plan' => date("Y-m-d H:i:s", strtotime($request->date_plan_arrival." ".$request->time_plan_arrival))]);
        $request->merge(['departure_plan' => date("Y-m-d H:i:s", strtotime($request->date_plan_departure." ".$request->time_plan_departure))]);

        $validator =  Validator::make($request->all(),[
            'customer_pickup_id' =>['required'],
            'cycle' => ['required','regex:/^[0-9.-]/'],
            'cycle_time_preparation' => ['required','regex:/^[0-9.-]/'],
            'help_column' => ['required'],
            'plan_time_preparation' => ['required'],
            'time_hour' => ['required'],
            'shift' => ['required'],
            'pic' => ['required'],
            'plan_date_preparation' => ['required'],

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

            // convert time am/pm ke 24 ours
            $plan_date_preparation = date("Y-m-d ", strtotime($request->plan_date_preparation));
            $request->merge(['plan_date_preparation' => $plan_date_preparation]);

            try {
                PreparationDelivery::create($request->all());
                DB::commit();

                return redirect('/delivery/preparation')->with('success', 'Schedule '.$request->help_column.' Added!');
            } catch (\Throwable $th) {
                // throw $th;
                DB::rollback();

                return redirect('/delivery/preparation')->with('fail', "Add Schedule Failed! [105]");
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
            $data = DeliveryPrepareCustomer::where('help_column', $request->help_column)->first();
            return $data ;
        } catch (\Throwable $th) {
            return '404';
        }
    }

    public function start($id, Request $request)
    {
        $data = PreparationDelivery::find($id);
        $npk=  Auth::user()->npk;
        

        if ($request->ajax()) {
            try {
                //code...
                $data->start_preparation = date("Y-m-d H:i:s");
                $data->date_preparation = date("Y-m-d");
                $data->start_by = $npk;
                $data->status = 1;
                $data->save();
                $message='<b>======== PREPARATION ========</b>'.chr(10).chr(10);
                $message .= '<b>Preparation</b> :'.$data->help_column.''.chr(10).'<b>Plan Preparation Date</b> :'.date('d-m-Y', strtotime($data->plan_date_preparation)).''.chr(10).'<b>Plan Preparation time</b> :'.$data->plan_time_preparation.''.chr(10).'<b>Started '.' by</b>: NPK'.$npk;
    
                $this->sendTelegram('-690929411',$message );
                return date("Y-m-d H:i:s");
            } catch (\Throwable $th) {
                // throw $th;
                return '404';
            }
        } else {
            try {
                //code...
                $data->start_preparation = date("Y-m-d H:i:s");
                $data->date_preparation = date("Y-m-d");
                $data->start_by = $npk;
                $data->status = 1;
                $data->save();
                $message='<b>======== PREPARATION ========</b>'.chr(10).chr(10);
                $message .= '<b>Preparation</b> :'.$data->help_column.''.chr(10).'<b>Plan Preparation Date</b> :'.date('d-m-Y', strtotime($data->plan_date_preparation)).''.chr(10).'<b>Plan Preparation time</b> :'.$data->plan_time_preparation.''.chr(10).'<b>Started '.' by</b>: NPK'.$npk;
    
                $this->sendTelegram('-690929411',$message );
                return redirect('/delivery/preparation/member')->with('success', 'Preparation '.$data->help_column.'Started!');
            } catch (\Throwable $th) {
                // throw $th;
                return redirect('/delivery/preparation/member')->with('fail', 'Preparation '.$data->help_column.' Fail!');
            }
        }
        
    }

    public function end($id, Request $request)
    {
        $data = PreparationDelivery::find($id);
        $npk=  Auth::user()->npk;

        $now =date("Y-m-d H:i:s");
        
        if ($request->ajax()) {
            try {
                //cek status actual vs plan
                $status_name='';
                if ($now < date("Y-m-d H:i:s", strtotime($data->plan_date_preparation." ".$data->plan_time_preparation . '-20 minutes'))) {
                    # advance
                    $data->status = 3;
                    $status_name='advanced';
    
                } elseif($now >= date("Y-m-d H:i:s", strtotime($data->plan_date_preparation." ".$data->plan_time_preparation . '-20 minutes')) && $now <= date("Y-m-d H:i:s", strtotime($data->plan_date_preparation." ".$data->plan_time_preparation )) ) {
                    # ontime
                    $data->status = 4;
                    $status_name='ontime';
                    
                }else {
                    # delay
                    $data->status = 5;
                    $status_name='delayed';
                    
                }
    
                $data->end_preparation = $now;
                $data->end_by = $npk;
                $data->time_preparation =  abs(strtotime ( $data->start_preparation ) - strtotime ( $now))/(60);
                $data->save();
                $message='<b>======== PREPARATION ========</b>'.chr(10).chr(10);
                $message .= '<b>Preparation</b> : '.$data->help_column.' '.chr(10).'<b>Plan Preparation Date</b> :'.date('d-m-Y', strtotime($data->plan_date_preparation)).' '.chr(10).'<b>Plan Preparation Time </b> :'.$data->plan_time_preparation.' '.chr(10).'<b>Finished By </b>:'.' NPK'.$npk.chr(10).'<b>Status</b>:'.$status_name;
                $this->sendTelegram('-690929411',$message );
                return $status_name;
            } catch (\Throwable $th) {
                return "404";
                // throw $th;
            }
        } else {
            try {
                //cek status actual vs plan
                $status_name='';
                if ($now < date("Y-m-d H:i:s", strtotime($data->plan_date_preparation." ".$data->plan_time_preparation . '-20 minutes'))) {
                    # advance
                    $data->status = 3;
                    $status_name='advanced';
    
                } elseif($now >= date("Y-m-d H:i:s", strtotime($data->plan_date_preparation." ".$data->plan_time_preparation . '-20 minutes')) && $now <= date("Y-m-d H:i:s", strtotime($data->plan_date_preparation." ".$data->plan_time_preparation )) ) {
                    # ontime
                    $data->status = 4;
                    $status_name='ontime';
                    
                }else {
                    # delay
                    $data->status = 5;
                    $status_name='delayed';
                    
                }
    
                $data->end_preparation = $now;
                $data->end_by = $npk;
                $data->time_preparation =  abs(strtotime ( $data->start_preparation ) - strtotime ( $now))/(60);
                $data->save();
                $message='<b>======== PREPARATION ========</b>'.chr(10).chr(10);
                $message .= '<b>Preparation</b> : '.$data->help_column.' '.chr(10).'<b>Plan Preparation Date</b> :'.date('d-m-Y', strtotime($data->plan_date_preparation)).' '.chr(10).'<b>Plan Preparation Time </b> :'.$data->plan_time_preparation.' '.chr(10).'<b>Finished By </b>:'.' NPK'.$npk.chr(10).'<b>Status</b>:'.$status_name;
                $this->sendTelegram('-690929411',$message );
                return redirect('/delivery/preparation/member')->with('success', 'Preparation '.$data->help_column.' Finished!');
            } catch (\Throwable $th) {
                return redirect('/delivery/preparation/member')->with('fail', 'Preparation '.$data->help_column.' Fail!');
                // throw $th;
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
            //throw $th;
        }
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_POST, 0);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // $response = curl_exec ($ch);
        // $err = curl_error($ch); 
        // curl_close ($ch);
    }

    public function export(Request $request) 
    {
        // dd($request);
        $from_date=$request->min;
        $to_date = $request->max;
        $status_prepare = $request->select_status;
        $status_arrival = $request->select_status_arrival;
        $status_departure = $request->select_status_departure;
        $customer = $request->help_column;
        
        if ($from_date != null && $to_date != null) {
            $filename = 'Schedule Preparation & Delivery '.$from_date.'_to_'.$to_date.'.xlsx';
        } else {
            $date = date("Y-m-d");
            $filename = 'Schedule Preparation & Delivery '.$date.'.xlsx';
        }
        
         return Excel::download(new PreparationExport($from_date,$to_date, $status_prepare, $status_arrival ,$status_departure, $customer), $filename);
    }

    public function arrival(Request $request)
    {
        $driver_name = $request->driver_name;
        $id = $request->id;
        $now =date("Y-m-d H:i:s");
        
        try {
            $data =PreparationDelivery::find($id);
            //cek status actual vs plan
            $status_name='';
            // isi siapa trigger nya
            $data->security_name_arrival = Auth::user()->name;
            $data->driver_name = $driver_name;

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

            $message='<b>======== ARRIVAL ========</b>'.chr(10).chr(10);
            
            $message .= '<b>Delivery Arrival</b> : '.$data->help_column.' '.chr(10).'<b>Plan Date</b> :'.date('d-m-Y H:i:s', strtotime($data->arrival_plan)).''.chr(10).'<b>Actual Date</b> :'.date('d-m-Y H:i:s', strtotime($data->arrival_actual)).' '.chr(10).'<b>Status</b>: '.$status_name;

            $this->sendTelegram('-690929411',$message );

            if (Auth::user()->roles->pluck('security')) {
                return redirect('/delivery/preparation/security')->with('success', $data->help_column.' Vendor Arrived!');
            } else {
                return redirect('/delivery/preparation')->with('success', $data->help_column.' Vendor Arrived!');
            }
            

        } catch (\Throwable $th) {
            if (Auth::user()->roles->pluck('security')) {
                return redirect('/delivery/preparation/security')->with('fail', $data->help_column.' Failed Update!');
            } else {
                return redirect('/delivery/preparation')->with('fail', $data->help_column.' Failed Update!');
            }
        }
    }

    public function departure($id)
    {
        $data =PreparationDelivery::find($id);
        
        $now =date("Y-m-d H:i:s");

        
        try {
            //cek status actual vs plan
            $status_name='';
            // isi siapa trigger nya
            $data->security_name_departure = Auth::user()->name;

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

            $message='<b>======== DEPARTURE ========</b>'.chr(10).chr(10);
            
            $message .= '<b>Delivery Departure</b> : '.$data->help_column.''.chr(10).'<b>Plan Date</b> :'.date('d-m-Y H:i:s', strtotime($data->departure_plan)).''.chr(10).'<b>Actual Date</b> :'.date('d-m-Y H:i:s', strtotime($data->departure_actual)).' '.chr(10).'<b>Status</b>: '.$status_name;
             
            $this->sendTelegram('-690929411',$message );

            if (Auth::user()->roles->pluck('security')) {
                return redirect('/delivery/preparation/security')->with('success', $data->help_column.' Vendor Departured!');
            } else {
                return redirect('/delivery/preparation')->with('success', $data->help_column.' Vendor Departured!');
            }
        } catch (\Throwable $th) {
            if (Auth::user()->roles->pluck('security')) {
                return redirect('/delivery/preparation/security')->with('fail', $data->help_column.' Failed Update!');
            } else {
                return redirect('/delivery/preparation')->with('fail', $data->help_column.' Failed Update!');
            }
        }
    }

    public function update_delay(Request $request)
    {
        $selection = PreparationDelivery::find($request->id);
        $npk=  Auth::user()->npk;
        DB::beginTransaction();
        try {
            $selection->update($request->all());
            DB::commit();

            // kirim telegram
            $message='<b>==========   DELAY    =========</b>'.chr(10).'<b>======== PREPARATION ========</b>'.chr(10).chr(10);
            $message .= '<b>Preparation</b> : '.$selection->help_column.' '.chr(10).'<b>Plan Preparation Date</b> :'.date('d-m-Y', strtotime($selection->plan_date_preparation)).' '.chr(10).'<b>Plan Preparation Time </b>:'.$selection->plan_time_preparation.' '.chr(10).'<b>Finished By </b>:'.' NPK'.$npk.chr(10).'<b>Problem Identification : </b>'.$request->problem.chr(10).'<b>Corrective Action: </b>'.chr(10).$request->remark;
            $this->sendTelegram('-690929411',$message );
            
            $row_1 = $selection->help_column; 
            $row_2 =  date('d-m-Y', strtotime($selection->plan_date_preparation));
            $row_3 = $selection->plan_time_preparation;
            $row_4 = ' NPK'.$npk;
            $row_5 = $request->problem;
            $row_6 = $request->remark;
            $row_7 = $selection->arrival_plan;
            // kirim email
            Mail::send('emails.preparation_delay', [  'row_1' => $row_1, 'row_2' => $row_2, 'row_3' => $row_3,'row_4' => $row_4, 'row_5' => $row_5,'row_6' => $row_6,'row_7' => $row_7  ], function($message) use($request){
                $message->to("miqdad.amarullah@astra-juoku.com");
                $message->subject('Preparation Delay');
            });

            return redirect('/delivery/preparation/member')->with('success', 'Schedule '.$selection->customer_pickup_id.' Updated!');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollback();
            // return redirect('/delivery/preparation/member')->with("fail","Failed Update! [105]" );
        }
    }

    public function check_delay()
    {
        
        $data_delay_baru_start = PreparationDelivery::where(DB::raw('DATE_FORMAT(CONCAT(plan_date_preparation," ",plan_time_preparation), "%Y-%m-%d %H:%i:%s")'), '<', date("Y-m-d H:i:s"))->where('status', '1')->get();
        $data_delay_belum_start = PreparationDelivery::where(DB::raw('DATE_FORMAT(CONCAT(plan_date_preparation," ",plan_time_preparation), "%Y-%m-%d %H:%i:%s")'), '<', date("Y-m-d H:i:s")  )->where('status', NULL)->get();
        $npk=  Auth::user()->npk;
        $now =date("Y-m-d H:i:s");
        
        // dd($data_delay_baru_start);
        // update ke status delay dulu, data_delay_baru_start
        foreach ($data_delay_baru_start as $item) {
            $selection = PreparationDelivery::find( $item->id);
            DB::beginTransaction();
            try {
                $selection->status = '5';
                $selection->end_preparation = $selection2->plan_date_preparation." ".$selection2->plan_time_preparation;
                $selection->end_by = $npk;
                $selection->time_preparation =   abs(strtotime ( $selection->start_preparation ) - strtotime ( $now))/(60);
                $selection->save();
                DB::commit();
            } catch (\Throwable $th) {
                // throw $th;
                DB::rollback();
            }
        }
        foreach ($data_delay_belum_start as $item2) {
            $selection2 = PreparationDelivery::find( $item2->id);
            DB::beginTransaction();
            try {
                $selection2->end_preparation = date("Y-m-d H:i:s", strtotime( $selection2->plan_date_preparation." ".$selection2->plan_time_preparation));
                $selection2->date_preparation = $now;
                $selection2->start_preparation = $selection2->plan_date_preparation." ".$selection2->plan_time_preparation;
                $selection2->status = '5';
                $selection2->end_by = $npk; 
                $selection2->start_by = $npk;
                // $selection2->time_preparation =  abs(strtotime ( $selection2->start_preparation ) - strtotime ( $now))/(60);
                $selection2->save();
                DB::commit();

            } catch (\Throwable $th) {
                DB::rollback();

                throw $th;
            }
            
        }

        // dd($data_delay_baru_start);
        $data_delay = PreparationDelivery::where('end_preparation', '>', DB::raw("CONCAT('',plan_date_preparation, plan_time_preparation)"))->where('remark', NULL)->where('status', '5')->where('problem', NULL)->where('pic','=', $npk)->limit(1)->get();
        return $data_delay;
    }
    
}
