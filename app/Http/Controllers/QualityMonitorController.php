<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QualityArea;
use App\Models\QualityProcess;
use App\Models\QualityModel;
use App\Models\QualityPart;
use App\Models\QualityMonitor;
use Illuminate\Support\Facades\DB;

class QualityMonitorController extends Controller
{

    function generateDocNumber() {
        // $doc_number = mt_rand(1000000000, 9999999999); // better than rand()
        // // call the same function if the barcode exists already
        // if (docNumberExists($doc_number)) {
        //     return generateDocNumber();
        // }
        // // otherwise, it's valid and can be used
        // return $doc_number;

        do {
            $doc_number = random_int(100000, 999999);
        } while (QualityMonitor::where("doc_number", "=", "AJI/QA/".$doc_number)->first()); 
        return $doc_number;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $qualityMonitors = QualityMonitor::with(['qualityArea', 'qualityProcess', 'qualityDistrict', 'qualityVillage']);

        // return view('quality.monitor.index', [
        //     'qualityMonitors' => $qualityMonitors->get(),
        // ]);

        $qualityMonitors = $qualityMonitors->get();

        $q_parts = QualityPart::all();
        $q_models = QualityModel::all();
        $q_processes = QualityProcess::all();
        $q_areas = QualityArea::all();

        // doc number
        $randomNumber = $this->generateDocNumber();

        return view('quality.monitor.index', compact('q_processes', 'q_areas', 'q_models', 'q_parts', 'qualityMonitors', 'randomNumber'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('quality.monitor.create');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
