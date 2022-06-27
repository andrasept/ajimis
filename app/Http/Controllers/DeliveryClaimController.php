<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\DeliveryClaim;
use App\Models\ManPowerDelivery;
use Illuminate\Support\Facades\DB;
use App\Models\DeliveryPrepareCustomer;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class DeliveryClaimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = DB::table('delivery_claim');

            $query= $query->select('delivery_claim.*')->get();

            return DataTables::of($query)->toJson();
        }else{
    
            $claims = DeliveryClaim::select('*')->get(); 

            return view('delivery.claim.claim', compact('claims'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $part_nos = Part::select('*')->orderBy('part_no_customer', 'asc')->get()->unique('part_no_customer');
        $shifts = ManPowerDelivery::select('*')->orderBy('shift', 'asc')->get()->unique('shift');
        return view("delivery.claim.create", compact( 'shifts','part_nos'));
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
     * @param  \App\Models\DeliveryClaim  $deliveryClaim
     * @return \Illuminate\Http\Response
     */
    public function show(DeliveryClaim $deliveryClaim)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeliveryClaim  $deliveryClaim
     * @return \Illuminate\Http\Response
     */
    public function edit(DeliveryClaim $deliveryClaim)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DeliveryClaim  $deliveryClaim
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeliveryClaim $deliveryClaim)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeliveryClaim  $deliveryClaim
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeliveryClaim $deliveryClaim, $id)
    {
        try {
            $data = DeliveryClaim::findOrFail($id);
            $array_image = explode(",", $data->evidence);
            foreach ($array_image as $key ) {
                Storage::disk('public')->delete('/delivery-claim-photo/'.$key);
            }
            $data->delete();
           
            return redirect('/delivery/claim')->with('success', 'Claim Deleted!');
        } catch (\Throwable $th) {
            // throw $th;
            return redirect('/delivery/claim')->with("fail","Failed Delete! [105]" );
        }
    }

    public function insert(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'customer_pickup_id' =>['required'],
            'claim_date' => ['required'],
            'problem' => ['required'],
            'part_number' => ['required'],
            'part_number_actual' => ['required'],
            'part_name' => ['required'],
            'part_name_actual' => ['required'],
            'category' => ['required'],
            'qty' => ['required'],
            'corrective_action' => ['required'],
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }else{
            DB::beginTransaction();

            // proses uplaod image evidence
            if ($request->hasFile('photo')) {
                $i = 0;
                $data = [];
                foreach ($request->file('photo') as $photo) {
                    $i++;
                    $name= $photo->hashName();
                    $photo->store('delivery-claim-photo');
                    array_push($data, $name); 
                }
    
                // insert hash name
                $img_names =implode(",", $data);
                $request->merge(['evidence' => $img_names]);
            }

            try {
                DeliveryClaim::create($request->all());
                DB::commit();

                return redirect('/delivery/claim')->with('success', 'Claim Added!');
            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;

                // return redirect('/delivery/claim')->with('fail', "Add Claim Failed! [105]");
            }
        }

        
    }

    public function get_data_part(Request $request)
    {
        try {
            $data =  Part::where('part_no_customer', $request->part_no)->first();
            return $data;
        } catch (\Throwable $th) {
            return '404';
        }
    }
}
