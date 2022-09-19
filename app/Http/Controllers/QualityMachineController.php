<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QualityProcess;
use App\Models\QualityArea;
use App\Models\QualityMachine;
use Illuminate\Support\Facades\DB;

class QualityMachineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $q_machines = QualityMachine::orderBy('id', 'DESC')->get();
        $q_processes = QualityProcess::all();
        $q_areas = QualityArea::all();

        return view('quality.machine.index', compact('q_machines','q_processes', 'q_areas'));
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
        // echo "test";
        $data['processes'] = QualityProcess::where("area_id", $request->area_id)->get(["name", "id"]); 
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

        $q_machine = new QualityMachine;
        $q_machine->area_id = $request->input('area_id');
        $q_machine->process_id = $request->input('process_id');
        $q_machine->name = $request->input('name');
        $q_machine->description = $request->input('description');
        $q_machine->created_by = $user_id;
        $q_machine->created_at = now();

        if ($q_machine->save()) {
            return redirect()->route('quality.machine.index')->withSuccess(__('Machine created successfully.'));
        }else{
            return redirect()->route('quality.machine.index')->withSuccess(__('Maaf terjadi kesalahan. Silahkan coba kembali.'));
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
    public function edit(QualityMachine $QualityMachine, $id)
    {
        $area_id = DB::table('quality_machines')->where('id', $id)->pluck('area_id');
        // echo $area_id; exit();
        $QualityMachine = QualityMachine::find($id);
        $q_areas = QualityArea::all();
        // $q_processes = QualityProcess::all();
        $q_processes = DB::table('quality_processes')->where('area_id', $area_id)->get();
        return view('quality.machine.edit', compact('QualityMachine','q_areas','q_processes'));
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
        $QualityMachine['area_id'] = $request->area_id;
        $QualityMachine['process_id'] = $request->process_id;
        $QualityMachine['name'] = $request->name;
        $QualityMachine['description'] = $request->description;
        $QualityMachine['updated_by'] = $user_id;
        $QualityMachine['updated_at'] = now();
        QualityMachine::find($id)->update($QualityMachine);
        return redirect()->route('quality.machine.index')
            ->withSuccess(__('Machine updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(QualityMachine $QualityMachine, $id)
    {
        $QualityMachine = QualityMachine::find($id);
        $QualityMachine->delete();

        return redirect()->route('quality.machine.index')
            ->withSuccess(__('Machine deleted successfully.'));
    }
}
