<?php

namespace App\Http\Controllers;

use App\Models\DeliveryLayoutArea;
use Illuminate\Http\Request;

class DeliveryLayoutAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data= [];
        $data[0]['photo']= asset('/image/user3.png');
        $data[1]['photo']= asset('/image/user3.png');
        $data[2]['photo']= asset('/image/user3.png');
        $data[3]['photo']= asset('/image/user3.png');
        $data[4]['photo']= asset('/image/user3.png');
        $data[5]['photo']= asset('/image/user2.png');
        $data[0]['npk']= '00001';
        $data[1]['npk']= '00002';
        $data[2]['npk']= '00003';
        $data[3]['npk']= '00004';
        $data[4]['npk']= '00005';
        $data[5]['npk']= '00006';

        return view('delivery.layout.index', compact('data'));
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
     * @param  \App\Models\DeliveryLayoutArea  $deliveryLayoutArea
     * @return \Illuminate\Http\Response
     */
    public function show(DeliveryLayoutArea $deliveryLayoutArea)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeliveryLayoutArea  $deliveryLayoutArea
     * @return \Illuminate\Http\Response
     */
    public function edit(DeliveryLayoutArea $deliveryLayoutArea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DeliveryLayoutArea  $deliveryLayoutArea
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeliveryLayoutArea $deliveryLayoutArea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeliveryLayoutArea  $deliveryLayoutArea
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeliveryLayoutArea $deliveryLayoutArea)
    {
        //
    }
}
