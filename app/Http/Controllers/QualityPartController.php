<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QualityArea;
use App\Models\QualityProcess;
use App\Models\QualityModel;
use App\Models\QualityPart;
use Illuminate\Support\Facades\DB;

class QualityPartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $q_parts = QualityPart::all();
        $q_models = QualityModel::all();
        $q_processes = QualityProcess::all();
        $q_areas = QualityArea::all();

        return view('quality.part.index', compact('q_processes', 'q_areas', 'q_models', 'q_parts'));
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
        $user_id = auth()->user()->id;

        $q_parts = new QualityPart;
        $q_parts->model_id = $request->input('model_id');
        $q_parts->name = $request->input('name');
        $q_parts->description = $request->input('description');
        $q_parts->low = $request->input('low');
        $q_parts->mid = $request->input('mid');
        $q_parts->high = $request->input('high');
        $q_parts->left = $request->input('left');
        $q_parts->center = $request->input('center');
        $q_parts->right = $request->input('right');
        $q_parts->photo = $request->input('photo');
        $q_parts->created_by = $user_id;
        $q_parts->created_at = now();

        if ($q_parts->save()) {
            return redirect()->route('quality.part.index')->withSuccess(__('Part created successfully.'));
        }else{
            return redirect()->route('quality.part.index')->withSuccess(__('Maaf terjadi kesalahan. Silahkan coba kembali.'));
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
