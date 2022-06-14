<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManPowerDelivery;
use App\Exports\PreparationExport;
use Illuminate\Support\Facades\DB;
use App\Models\PreparationDelivery;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\DeliveryPrepareCustomer;
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

            $query = DB::table('delivery_preparation');

            

            if ($request->member == '1') {
                $query->where('status', '=', '1')->orWhere('status', '=', '2')->orWhere('status', '=', NULL);
            }else {
                if (isset($request->min) && isset($request->max)) {
                    
                    $query->whereBetween('plan_date_preparation', [date("Y-m-d", strtotime($request->min)), date("Y-m-d", strtotime($request->max))]);
                }

                if (isset($request->help_column) ) {
                    
                    if ($request->help_column == '-') {
                        # code...
                    } else {
                        $query->where('help_column',$request->help_column);
                    }
                    
                }

                if(isset($request->status) && $request->status != 'all' ){
                    if ($request->status == "0") {
                        
                        $query->where('status', NULL);
                        
                    } else {

                        $query->where('status',$request->status );
                   
                    }
                    
                }
            }

            

            $query= $query->select('delivery_preparation.*')->get();

            return DataTables::of($query)->toJson();
        }else{
    
            $customers = DeliveryPrepareCustomer::select('*')->orderBy('help_column', 'asc')->get(); 

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
        return view('delivery.preparation.preparation.preparation_member');
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
        $validator =  Validator::make($request->all(),[
            'plan_date_preparation' =>['required'],
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
            
            return redirect('/delivery/preparation')->with('success', 'Data Preparation '.$request->customer_pickup_id.' Updated!');
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
        
        $validator =  Validator::make($request->all(),[
            // 'date_delivery' =>['required'],
            'customer_pickup_id' =>['required'],
            'cycle' => ['required','regex:/^[0-9.-]/'],
            'cycle_time_preparation' => ['required','regex:/^[0-9.-]/'],
            'help_column' => ['required'],
            'plan_time_preparation' => ['required'],
            'time_hour' => ['required'],
            'shift' => ['required'],
            'pic' => ['required'],
            'plan_date_preparation' => ['required'],
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
            $data = DeliveryPrepareCustomer::where('help_column', $request->help_column)->first();
            return $data ;
        } catch (\Throwable $th) {
            return '404';
        }
    }
    public function start($id)
    {
        $data = PreparationDelivery::find($id);
        $npk=  Auth::user()->npk;
        

        try {
            //code...
            $data->start_preparation = date("Y-m-d H:i:s");
            $data->date_preparation = date("Y-m-d");
            $data->start_by = $npk;
            $data->status = 1;
            $data->save();
            $message = ' <b>Preparation</b> :'.$data->help_column.''.chr(10).'<b>Plan Preparation Date</b> :'.date('d-m-Y', strtotime($data->plan_date_preparation)).''.chr(10).'<b>Plan Preparation time</b> :'.$data->plan_time_preparation.''.chr(10).'<b>Started '.' by</b>: NPK'.$npk;

            $this->sendTelegram('-690929411',$message );
            return redirect('/delivery/preparation/member')->with('success', 'Preparation '.$data->help_column.'Started!');
        } catch (\Throwable $th) {
            // throw $th;
            return redirect('/delivery/preparation/member')->with('fail', 'Preparation '.$data->help_column.' Fail!');
        }
    }
    public function end($id)
    {
        $data = PreparationDelivery::find($id);
        $npk=  Auth::user()->npk;

        $now =date("Y-m-d H:i:s");
        
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
            $message = '<b>Preparation</b> : '.$data->help_column.' '.chr(10).'<b>Plan Preparation Date</b> :'.date('d-m-Y', strtotime($data->plan_date_preparation)).' '.chr(10).'<b>Plan Preparation Time </b> :'.$data->plan_time_preparation.' '.chr(10).'<b>Finished By </b>:'.' NPK'.$npk.chr(10).'<b>Status</b>:'.$status_name;
            $this->sendTelegram('-690929411',$message );
            return redirect('/delivery/preparation/member')->with('success', 'Preparation '.$data->help_column.' Finished!');
        } catch (\Throwable $th) {
            return redirect('/delivery/preparation/member')->with('fail', 'Preparation '.$data->help_column.' Fail!');
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

    public function export(Request $request) 
    {

        $from_date=$request->min;
        $to_date = $request->max;
        $status = $request->select_status;
        
        if ($from_date != null && $to_date != null) {
            $filename = 'Preparation_'.$from_date.'_to_'.$to_date.'.xlsx';
        } else {
            $date = date("Y-m-d");
            $filename = 'preparation_per_'.$date.'.xlsx';
        }
        
        
         return Excel::download(new PreparationExport($from_date,$to_date, $status), $filename);
    }
}
