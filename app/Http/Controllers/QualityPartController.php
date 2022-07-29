<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QualityArea;
use App\Models\QualityProcess;
use App\Models\QualityMachine;
use App\Models\QualityModel;
use App\Models\QualityPart;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\UploadedFile;
use App\Http\Requests\StoreFileRequest;
use Carbon\Carbon;
use Validator;

class QualityPartController extends Controller
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
        $q_parts = QualityPart::all();

        return view('quality.part.index', compact('q_areas', 'q_processes', 'q_machines', 'q_models', 'q_parts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $q_areas = QualityArea::all();
        $q_processes = QualityProcess::all();
        $q_machines = QualityMachine::all();
        $q_models = QualityModel::all();
        $q_parts = QualityPart::all();

        return view('quality.part.create', compact('q_areas', 'q_processes', 'q_machines', 'q_models', 'q_parts'));
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

        $area_id = $request->input('area_id');  
        $process_id = $request->input('process_id');  
        $machine_id = $request->input('machine_id');  
        $model_id = $request->input('model_id');  
        $name = $request->input('name');  
        $description = $request->input('description');  
        $low = $request->input('low');  
        $mid = $request->input('mid');  
        $high = $request->input('high');  
        $left = $request->input('left');  
        $center = $request->input('center');  
        $right = $request->input('right');   
        
        $save = new QualityPart; 
        // $save->photo = $photo;
        $save->area_id = $area_id; 
        $save->process_id = $process_id; 
        $save->machine_id = $machine_id; 
        $save->model_id = $model_id; 
        $save->name = $name; 
        $save->description = $description; 
        $save->low = $low; 
        $save->mid = $mid; 
        $save->high = $high; 
        $save->left = $left; 
        $save->center = $center; 
        $save->right = $right; 
        $save->created_by = $user_id; 
        $save->created_at = now(); 

        if($request->file('photo')){
            $file= $request->file('photo');
            // $filename= date('YmdHi').$file->getClientOriginalName();
            $filename= $request->file('photo')->getClientOriginalName();
            $file-> move(public_path('public/quality'), $filename);
            $save->photo = $filename;
        }

        $save->save(); 
        return redirect()->route('quality.part.index')->withSuccess(__('Part added successfully.'));

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
        $QualityPart = QualityPart::find($id);
        $QualityPart->delete();

        return redirect()->route('quality.part.index')
            ->withSuccess(__('Model deleted successfully.'));
    }
}
