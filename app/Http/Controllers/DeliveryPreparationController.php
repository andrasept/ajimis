<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManPowerDelivery;
use Illuminate\Support\Facades\DB;
use App\Models\PreparationDelivery;
use Illuminate\Support\Facades\Auth;
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

            $query = DB::table('delivery_preparation');

            

            if ($request->member == '1') {
                $query->where('status', '=', '1')->orWhere('status', '=', '2')->orWhere('status', '=', NULL);
            }else {
                if (isset($request->min) && isset($request->max)) {
                    
                    $query->whereBetween('date_delivery', [date("Y-m-d", strtotime($request->min)), date("Y-m-d", strtotime($request->max))]);
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
            return view('delivery.preparation.preparation.preparation');
        }
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
        $customers = DeliveryPickupCustomer::select('*')->orderBy('help_column', 'asc')->get(); 
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
        $customers = DeliveryPickupCustomer::get(); 
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
            
            return redirect()->back()->with("fail","".implode(" ",$validator->errors()->all()) );
        } else {
            $selection = PreparationDelivery::find($request->id);
            try {
                $selection->update($request->all());
            } catch (\Throwable $th) {
                // throw $th;
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
        $npk=  Auth::user()->npk;
        
 
        
        try {
            //code...
            $data->start_preparation = date("Y-m-d H:i:s");
            $data->date_preparation = date("Y-m-d");
            $data->start_by = $npk;
            $data->status = 1;
            $data->save();
            $message = 'Preparation '.$data->help_column.' untuk delivery date '.date('d-m-Y', strtotime($data->date_delivery)).' dan pickup time '.$data->time_pickup.'  Started'.' by NPK:'.$npk;
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
            //code...
            $data->end_preparation = $now;
            $data->end_by = $npk;
            $data->status = 3;
            $data->time_preparation =  abs(strtotime ( $data->start_preparation ) - strtotime ( $now))/(60);
            $data->save();
            $message = 'Preparation '.$data->help_column.' untuk delivery date '.date('d-m-Y', strtotime($data->date_delivery)).' dan pickup time '.$data->time_pickup.'  Finished'.' by NPK:'.$npk;
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
        $url = 'https://api.telegram.org/bot'.$token.'/sendMessage?chat_id='.$chat_id.'&text='.$text;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec ($ch);
        $err = curl_error($ch); 
        curl_close ($ch);
    }
}
