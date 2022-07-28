<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DeliveryHenkatenDetail;
use Yajra\DataTables\Facades\DataTables;

class DeliveryHenkatenDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = DB::table('delivery_henkaten_detail');

            $query= $query->select('delivery_henkaten_detail.*')->get();

            return DataTables::of($query)->toJson();
        }else{

            return view('delivery.henkaten.henkaten');
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\DeliveryHenkatenDetail  $deliveryHenkatenDetail
     * @return \Illuminate\Http\Response
     */
    public function show(DeliveryHenkatenDetail $deliveryHenkatenDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeliveryHenkatenDetail  $deliveryHenkatenDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(DeliveryHenkatenDetail $deliveryHenkatenDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DeliveryHenkatenDetail  $deliveryHenkatenDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeliveryHenkatenDetail $deliveryHenkatenDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeliveryHenkatenDetail  $deliveryHenkatenDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeliveryHenkatenDetail $deliveryHenkatenDetail)
    {
        //
    }
}
