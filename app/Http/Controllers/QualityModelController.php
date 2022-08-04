<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QualityArea;
use App\Models\QualityProcess;
use App\Models\QualityMachine;
use App\Models\QualityModel;
use App\Models\QualityPart;
use Illuminate\Support\Facades\DB;

class QualityModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $q_areas = QualityArea::all();
        $q_processes = QualityProcess::all();
        $q_machines = QualityMachine::all();
        $q_models = QualityModel::all();

        return view('quality.model.index', compact('q_areas', 'q_processes', 'q_machines','q_models'));
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

    public function fetchProcess(Request $request)
    {
        $data['processes'] = QualityProcess::where("area_id", $request->area_id)->get(["name", "id"]); 
        return response()->json($data);
    }

    public function fetchMachine(Request $request)
    {
        $data['machines'] = QualityMachine::where("process_id", $request->process_id)->get(["name", "id"]); 
        return response()->json($data);
    }

    public function fetchModel(Request $request)
    {
        $data['models'] = QualityModel::where("machine_id", $request->machine_id)->get(["name", "id"]); 
        return response()->json($data);
    }

    public function fetchPart(Request $request)
    {
        $data['parts'] = QualityPart::where("model_id", $request->model_id)->get(["name", "id"]); 
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = auth()->user()->id;

        $q_models = new QualityModel;
        $q_models->area_id = $request->input('area_id');
        $q_models->process_id = $request->input('process_id');
        $q_models->machine_id = $request->input('machine_id');
        $q_models->name = $request->input('name');
        $q_models->description = $request->input('description');
        $q_models->created_by = $user_id;
        $q_models->created_at = now();

        if ($q_models->save()) {
            return redirect()->route('quality.model.index')->withSuccess(__('Model created successfully.'));
        }else{
            return redirect()->route('quality.model.index')->withSuccess(__('Maaf terjadi kesalahan. Silahkan coba kembali.'));
        }
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
    public function edit(QualityModel $QualityModel, $id)
    {
        $area_id = DB::table('quality_models')->where('id', $id)->pluck('area_id');
        $process_id = DB::table('quality_models')->where('id', $id)->pluck('process_id');
        $machine_id = DB::table('quality_models')->where('id', $id)->pluck('machine_id');
        $QualityModel = QualityModel::find($id);
        $q_areas = QualityArea::all();
        $q_processes = DB::table('quality_processes')->where('area_id', $area_id)->get();
        $q_machines = DB::table('quality_machines')->where('process_id', $process_id)->get();
        return view('quality.model.edit', compact('QualityModel','q_areas','q_processes','q_machines'));
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
        $user_id = auth()->user()->id;
        $QualityModel['area_id'] = $request->area_id;
        $QualityModel['process_id'] = $request->process_id;
        $QualityModel['machine_id'] = $request->machine_id;
        $QualityModel['name'] = $request->name;
        $QualityModel['description'] = $request->description;
        $QualityModel['updated_by'] = $user_id;
        $QualityModel['updated_at'] = now();
        QualityModel::find($id)->update($QualityModel);
        return redirect()->route('quality.model.index')
            ->withSuccess(__('Model updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $QualityModel = QualityModel::find($id);
        $QualityModel->delete();

        return redirect()->route('quality.model.index')
            ->withSuccess(__('Model deleted successfully.'));
    }
}
