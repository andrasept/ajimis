<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManPowerDelivery;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\DeliveryPlanningRefreshment;

class DeliveryPlanningRefreshmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('delivery_planning_refreshment');
            $query= $query->select('delivery_planning_refreshment.*')->get();
            return DataTables::of($query)->toJson();
        } else {
            return view('delivery.planning_refreshment.planning_refreshment');
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mp = ManPowerDelivery::all();
        return view('delivery.planning_refreshment.planning_refreshment_create', compact('mp'));
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
     * @param  \App\Models\DeliveryPlanningRefreshment  $deliveryPlanningRefreshment
     * @return \Illuminate\Http\Response
     */
    public function show(DeliveryPlanningRefreshment $deliveryPlanningRefreshment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeliveryPlanningRefreshment  $deliveryPlanningRefreshment
     * @return \Illuminate\Http\Response
     */
    public function edit(DeliveryPlanningRefreshment $deliveryPlanningRefreshment, $id)
    {
        $data = DeliveryPlanningRefreshment::findOrFail($id);
        $mp = ManPowerDelivery::all();
        return view('delivery.planning_refreshment.planning_refreshment_edit', compact('data','mp'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DeliveryPlanningRefreshment  $deliveryPlanningRefreshment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeliveryPlanningRefreshment $deliveryPlanningRefreshment)
    {
        $validator =  Validator::make($request->all(),[
            'training' =>['required'],
            'user_id' =>['required'],
            'plan_date_time' => ['required'],
        ]);

        if ($validator->fails()) {
            
            return back()->withInput()->withErrors($validator);
        } else {
            $selection = DeliveryPlanningRefreshment::find($request->id);
            DB::beginTransaction();
            try {
                $selection->update($request->all());
                DB::commit();

            } catch (\Throwable $th) {
                // throw $th;
                DB::rollback();
                return redirect('/delivery/planning_refreshment')->with("fail","Failed Update! [105]" );
            }
            
            return redirect('/delivery/planning_refreshment')->with('success', 'Planning Updated!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeliveryPlanningRefreshment  $deliveryPlanningRefreshment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, DeliveryPlanningRefreshment $deliveryPlanningRefreshment)
    {
        try {
            $data = DeliveryPlanningRefreshment::findOrFail($id);
            $data->delete();
            return redirect('/delivery/planning_refreshment')->with("success","Plan Deleted!" );
        } catch (\Throwable $th) {
            // throw $th;
            return redirect('/delivery/planning_refreshment')->with("fail","Failed Delete! [105]" );
        }
    }

    public function insert(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'training' =>['required'],
            'user_id' =>['required'],
            'plan_date_time' => ['required'],
        ]);

        if ($validator->fails()) {
            
            return back()->withInput()->withErrors($validator);
        } else {
            DB::beginTransaction();
            try {
                DeliveryPlanningRefreshment::create($request->all());
               
                DB::commit();

            } catch (\Throwable $th) {
                return $th->getMessage();
                DB::rollback();
                // return redirect('/delivery/planning_refreshment')->with("fail","Failed Insert! [105]" );
            }
            
            return redirect('/delivery/planning_refreshment')->with('success', 'Planning Inserted!');
        }
    }

    public function update_status($id)
    {
        try {
            $data = DeliveryPlanningRefreshment::find($id);
            $data->status = '1';
            $data->actual_date_time = date('Y-m-d H:i:s');
            $data->save();
            return redirect('/delivery/planning_refreshment')->with('success', 'Planning Updated!');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect('/delivery/planning_refreshment')->with('fail', 'Planning Update Failed!');
        }
    }
}
