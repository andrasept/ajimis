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
// use Illuminate\Support\Facades\Storage;
use Storage;
use File;

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
            $filename = date('YmdHis').$file->getClientOriginalName();
            $file->move(public_path('quality/wi'), $filename);

            // $file_resize = $request->file('photo');
            // $filename_thumb = "thumb_".date('YmdHi').$file_resize->getClientOriginalName();
            // $file_resize->move(public_path('quality/wi'), $filename_thumb);

            // for save thumnail image
            // $thumbnailPath = 'public/thumbnail/';
            // $ImageUpload->resize(250,125);
            // $ImageUpload = $ImageUpload->save($thumbnailPath.time().$files->getClientOriginalName());

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
        $area_id = DB::table('quality_parts')->where('id', $id)->pluck('area_id');
        $process_id = DB::table('quality_parts')->where('id', $id)->pluck('process_id');
        $machine_id = DB::table('quality_parts')->where('id', $id)->pluck('machine_id');
        $model_id = DB::table('quality_parts')->where('id', $id)->pluck('model_id');
        // dd($model_id);
        $QualityPart = QualityPart::find($id);
        $q_areas = QualityArea::all();
        $q_processes = DB::table('quality_processes')->where('area_id', $area_id)->get();
        $q_machines = DB::table('quality_machines')->where('process_id', $process_id)->get();
        $q_models = DB::table('quality_models')->where('machine_id', $machine_id)->get();
        // dd($q_models);
        return view('quality.part.edit', compact('QualityPart','q_areas','q_processes','q_machines','q_models'));
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
        $QualityPart['area_id'] = $request->area_id;
        // dd($request->area_id);
        $QualityPart['process_id'] = $request->process_id;
        $QualityPart['machine_id'] = $request->machine_id;
        $QualityPart['model_id'] = $request->model_id;
        $QualityPart['name'] = $request->name;
        $QualityPart['description'] = $request->description;
        $QualityPart['low'] = $request->low;
        $QualityPart['mid'] = $request->mid;
        $QualityPart['high'] = $request->high;
        $QualityPart['left'] = $request->left;
        $QualityPart['center'] = $request->center;
        $QualityPart['right'] = $request->right;

        // change photo
        if($request->file('photo')){
            $file= $request->file('photo');
            $filename = date('YmdHi').$file->getClientOriginalName();
            // upload
            $file->move(public_path('quality/wi'), $filename);
            // update
            $QualityPart['photo'] = $filename;

            // delete file
            if(File::exists(public_path('quality/wi/'.$request->photo_existing))){
                File::delete(public_path('quality/wi/'.$request->photo_existing));
            }
        }

        $QualityPart['updated_by'] = $user_id;
        $QualityPart['updated_at'] = now();
        QualityPart::find($id)->update($QualityPart);
        // dd($QualityPart);
        return redirect()->route('quality.part.index')
            ->withSuccess(__('Part updated successfully.'));
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

        // dd($QualityPart->photo);

        // if(Storage::exists('quality/wi/'.$QualityPart->photo)){
        //     Storage::delete('quality/wi/'.$QualityPart->photo);
        //     // Delete Multiple File like this way
        //     // Storage::delete(['upload/test.png', 'upload/test2.png']);
        // }else{
        //     dd('File does not exists.');
        // }


        if(File::exists(public_path('quality/wi/'.$QualityPart->photo))){
            File::delete(public_path('quality/wi/'.$QualityPart->photo));
        }
        // else{
        //     dd('Filed does not exists.');
        // }


        $QualityPart->delete();

        return redirect()->route('quality.part.index')
            ->withSuccess(__('Part deleted successfully.'));
    }
}
