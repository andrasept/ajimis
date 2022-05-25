<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManPowerDelivery;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class DeliveryManpowerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
    
            $query = DB::table('delivery_man_powers');

            return DataTables::of($query)->toJson();
        }else{
            return view('delivery.master.manpower.master_manpower');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('delivery.master.manpower.master_manpower_create');
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
     * @param  \App\Models\ManPowerDelivery  $manPowerDelivery
     * @return \Illuminate\Http\Response
     */
    public function show(ManPowerDelivery $manPowerDelivery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ManPowerDelivery  $manPowerDelivery
     * @return \Illuminate\Http\Response
     */
    public function edit(ManPowerDelivery $manPowerDelivery, $id)
    {
        $data = ManPowerDelivery::findOrFail($id);
        return view("delivery.master.manpower.master_manpower_edit", compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ManPowerDelivery  $manPowerDelivery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ManPowerDelivery $manPowerDelivery)
    {
        $validator = Validator::make($request->all(), [
            'npk' => ['required'],
            'name' => ['required'],
            'position' => ['required'],
            'title' => ['required'],
            'shift' => ['required'],
            'photo' => ['required'],
        ]);
        
        
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }else{
            
            DB::beginTransaction();
            try {
                // hapus photo
                $data = ManPowerDelivery::findOrFail($request->id);
                Storage::disk('public')->delete('/delivery-manpower-photo/'.$data->photo);
                // upload photo
                $request->file('photo')->store('delivery-manpower-photo');
                $photo = $request->file('photo')->hashName();


                $data->update([
                    'id' => $request->get('id'),
                    'npk' => $request->get('npk'),
                    'name' => $request->get('name'),
                    'position' => $request->get('position'),
                    'title' => $request->get('title'),
                    'shift' => $request->get('shift'),
                    'photo' => $photo,
                ]);
                $data->save();
                DB::commit();
                // $message = "SKU ".$request->sku." Part Added!, added By: ".auth()->user()->name;
                // $this->sendTelegram('-690929411',$message );
                return redirect('/delivery/master-manpower')->with('success', 'Data Man Power Delivery '.$request->npk.' Updated!');
            } catch (\Throwable $th) {
                throw $th;

                DB::rollback();
                return redirect('/delivery/master-manpower')->with('fail', "Update Man Power Failed! [105]");
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ManPowerDelivery  $manPowerDelivery
     * @return \Illuminate\Http\Response
     */
    public function destroy(ManPowerDelivery $manPowerDelivery, $id)
    {
        try {
            $data = ManPowerDelivery::findOrFail($id);
            Storage::disk('public')->delete('/delivery-manpower-photo/'.$data->photo);
            $data->delete();
            // $message = "SKU ".$data->sku." Man Power Deleted!, deleted By: ".auth()->user()->name;
            // $this->sendTelegram('-690929411',$message );
            return redirect('/delivery/master-manpower')->with("success","Man Power ".$data->npk." Deleted!" );
        } catch (\Throwable $th) {
            // throw $th;
            return redirect('/delivery/master-manpower')->with("fail","Failed Delete! [105]" );
        }
    }

    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'npk' => ['required', 'unique:delivery_man_powers'],
            'name' => ['required'],
            'position' => ['required'],
            'title' => ['required'],
            'shift' => ['required'],
            'photo' => ['required'],
        ]);
        
        
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }else{
            // upload photo
            $request->file('photo')->store('delivery-manpower-photo');
            $photo = $request->file('photo')->hashName();
            DB::beginTransaction();
            try {
                $user =  new ManPowerDelivery([
                    'npk' => $request->get('npk'),
                    'name' => $request->get('name'),
                    'position' => $request->get('position'),
                    'title' => $request->get('title'),
                    'shift' => $request->get('shift'),
                    'photo' => $photo,
                ]);
                $user->save();
                DB::commit();
                // $message = "SKU ".$request->sku." Part Added!, added By: ".auth()->user()->name;
                // $this->sendTelegram('-690929411',$message );
                return redirect('/delivery/master-manpower')->with('success', 'Data Man Power Delivery '.$request->npk.' Added!');
            } catch (\Throwable $th) {

                DB::rollback();
                return redirect('/delivery/master-manpower')->with('fail', "Add Man Power Failed! [105]");
            }
        }
    }
}
