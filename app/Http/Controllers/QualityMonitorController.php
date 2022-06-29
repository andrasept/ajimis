<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QualityArea;
use App\Models\QualityProcess;
use App\Models\QualityModel;
use App\Models\QualityPart;
use App\Models\QualityMonitor;
use App\Models\QualityCsQtime;
use App\Models\User;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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

        // dibuat urut urut per tahun tanggal menit saja, ujungnya pakai unique random, req Pandu
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
        // dependent dropdown
        $qualityMonitors = QualityMonitor::with(['qualityArea', 'qualityProcess', 'qualityModel', 'qualityPart']);
        // return view('quality.monitor.index', [
        //     'qualityMonitors' => $qualityMonitors->get(),
        // ]);
        $qualityMonitors = $qualityMonitors->get();

        $q_parts = QualityPart::all();
        $q_models = QualityModel::all();
        $q_processes = QualityProcess::all();
        $q_areas = QualityArea::all();
        $q_monitors = QualityMonitor::all();        

        // doc number
        $randomNumber = $this->generateDocNumber();

        // LANJUT DI SINI UNTUK MENAMPILKAN DETAIL SETIAP CYCLE DI SATU MONITOR NYA 
        // shift cs
        // $q_cs_qtimes = QualityCsQtime::all();
        $q_cs_qtimes_s1 = DB::table('quality_cs_qtimes')->where('shift', 1)->get(); // ini harusnya where id_monitor = xx   
        $q_cs_qtimes_s2 = DB::table('quality_cs_qtimes')->where('shift', 2)->get();
        $users = User::all();

        // cek user login
        $user_id = auth()->user()->id;

        // get users by its roles 
        $user_roles = User::whereHas("roles", function($q){ $q->where("name", "Leader Quality"); })->get();
        foreach ($user_roles as $key => $ur) {
            // echo $ur->id."<br/>";
            if ($user_id == $ur->id) {
                // echo "bener"; exit();
                $user_role = "Leader Quality";
            } else {
                $user_role = "";
            }
        }

        if ($user_role == "Leader Quality") {
            return view('quality.monitor.leader.index', compact(
                'q_processes', 'q_areas', 'q_models', 'q_parts', 'qualityMonitors', 'randomNumber', 'q_monitors', 
                'q_cs_qtimes_s1', 'q_cs_qtimes_s2', 
                'users'
            ));
        } else {
            return view('quality.monitor.index', compact(
                'q_processes', 'q_areas', 'q_models', 'q_parts', 'qualityMonitors', 'randomNumber', 'q_monitors', 
                'q_cs_qtimes_s1', 'q_cs_qtimes_s2', 
                'users'
            ));
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // dependent dropdown
        $qualityMonitors = QualityMonitor::with(['qualityArea', 'qualityProcess', 'qualityModel', 'qualityPart']);
        // return view('quality.monitor.index', [
        //     'qualityMonitors' => $qualityMonitors->get(),
        // ]);
        $qualityMonitors = $qualityMonitors->get();

        $q_parts = QualityPart::all();
        $q_models = QualityModel::all();
        $q_processes = QualityProcess::all();
        $q_areas = QualityArea::all();
        $q_monitors = QualityMonitor::all();

        // doc number
        $randomNumber = $this->generateDocNumber();

        return view('quality.monitor.create', compact('q_processes', 'q_areas', 'q_models', 'q_parts', 'qualityMonitors', 'randomNumber', 'q_monitors'));
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

        $q_monitors = new QualityMonitor;
        $q_monitors->user_id = $user_id;
        $q_monitors->doc_number = $request->input('doc_number');
        $q_monitors->judgement = 0;
        $q_monitors->quality_area_id = $request->input('quality_area_id');
        $q_monitors->quality_process_id = $request->input('quality_process_id');
        $q_monitors->quality_model_id = $request->input('quality_model_id');
        $q_monitors->quality_part_id = $request->input('quality_part_id');
        $q_monitors->created_by = $user_id;
        // $q_monitors->created_at = now();
        $q_monitors->created_at = $request->input('datetime');

        // checksheet category
        $cs_cat = $request->input('quality_cs');
        if ($cs_cat == 1) {
            $q_monitors->quality_cs_qtime = 1;
        } elseif ($cs_cat == 2) {
            $q_monitors->quality_cs_accuracy = 1;
        }

        if ($q_monitors->save()) {
            return redirect()->route('quality.monitor.index')->withSuccess(__('Monitor created successfully.'));
        }else{
            return redirect()->route('quality.monitor.index')->withSuccess(__('Maaf terjadi kesalahan. Silahkan coba kembali.'));
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
        $QualityMonitor = QualityMonitor::find($id);
        $QualityMonitor->delete();

        return redirect()->route('quality.monitor.index')
            ->withSuccess(__('Monitor Checksheet deleted successfully.'));
    }
}
