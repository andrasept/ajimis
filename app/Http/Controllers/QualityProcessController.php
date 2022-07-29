<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QualityProcess;
use App\Models\QualityArea;
use Illuminate\Support\Facades\DB;

class QualityProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $q_processes = QualityProcess::orderBy('id', 'DESC')->get();
        $q_areas = QualityArea::all();

        return view('quality.process.index', compact('q_processes', 'q_areas'));
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

        $q_process = new QualityProcess;
        $q_process->area_id = $request->input('area_id');
        $q_process->name = $request->input('name');
        $q_process->description = $request->input('description');
        $q_process->created_by = $user_id;
        $q_process->created_at = now();

        if ($q_process->save()) {
            return redirect()->route('quality.process.index')->withSuccess(__('Process created successfully.'));
        }else{
            return redirect()->route('quality.process.index')->withSuccess(__('Maaf terjadi kesalahan. Silahkan coba kembali.'));
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
    // public function edit($id)
    public function edit(QualityProcess $QualityProcess, $id)
    {
        $QualityProcess = QualityProcess::find($id);
        $q_areas = QualityArea::all();
        return view('quality.process.edit', compact('QualityProcess','q_areas'));
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
        $QualityProcess['area_id'] = $request->area_id;
        $QualityProcess['name'] = $request->name;
        $QualityProcess['description'] = $request->description;
        $QualityProcess['updated_by'] = $user_id;
        $QualityProcess['updated_at'] = now();
        QualityProcess::find($id)->update($QualityProcess);
        return redirect()->route('quality.process.index')
            ->withSuccess(__('Process updated successfully.'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(QualityProcess $QualityProcess, $id)
    {
        $QualityProcess = QualityProcess::find($id);
        $QualityProcess->delete();

        return redirect()->route('quality.process.index')
            ->withSuccess(__('Process deleted successfully.'));
    }
}
