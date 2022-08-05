<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QualityArea;
use App\Models\QualityProcess;
use App\Models\QualityMachine;
use App\Models\QualityModel;
use App\Models\QualityPart;
use App\Models\QualityMonitor;
use App\Models\QualityCsQtime;
use App\Models\QualityIpqc;
use App\Models\User;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Facades\DB;

use App\Http\Controllers\QualityCsQtimeController;

class QualityIpqcController extends Controller
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
        // $q_monitors = QualityMonitor::all();             
        $q_monitors = QualityIpqc::all();             

        // doc number
        // $randomNumber = $this->generateDocNumber();

        // LANJUT DI SINI UNTUK MENAMPILKAN DETAIL SETIAP CYCLE DI SATU MONITOR NYA 
        // shift cs
        // $q_cs_qtimes = QualityCsQtime::all();
        $q_cs_qtimes_s1 = DB::table('quality_cs_qtimes')->where('shift', 1)->get(); // ini harusnya where id_monitor = xx   
        $q_cs_qtimes_s2 = DB::table('quality_cs_qtimes')->where('shift', 2)->get();
        $users = User::all();

        // cek user login
        $user_id = auth()->user()->id;

        // get users by its roles 
        // $user_roles = User::whereHas("roles", function($q){ $q->where("name", "Leader Quality"); })->get();
        // foreach ($user_roles as $key => $ur) {
        //     // echo $ur->id."<br/>";
        //     if ($user_id == $ur->id) {
        //         // echo "bener"; exit();
        //         $user_role = "Leader Quality";
        //     } else {
        //         $user_role = "";
        //     }
        // }
        $user_role = (New QualityCsQtimeController)->getUserRole();
        // echo $user_role; exit();

        // LANJUT
        // set status "All Checked"
        // $app_status = DB::table('quality_cs_qtimes')
        //     ->where('quality_monitor_id',$q_monitor->id)
        //     ->get();    
        // $finish_status = "belum";
        // foreach($app_status as $as) {
        //     if($as->approval_status == 1) {
        //         // echo "belum";
        //         $finish_status = "belum";
        //     } elseif($as->approval_status == 2) {
        //         $finish_status = "belum";
        //     } elseif($as->approval_status == 3) {
        //         $finish_status = "belum";
        //     } elseif($as->approval_status == 4) {
        //         $finish_status = "belum";
        //     } elseif($as->approval_status == 5) {
        //         $finish_status = "belum";
        //     } else {
        //         $finish_status = "sudah";
        //     }
        // }

        if ($user_role == "Leader Quality") {
            return view('quality.ipqc.leader.index', compact(
                'q_processes', 'q_areas', 'q_models', 'q_parts', 
                // 'qualityMonitors','q_monitors', 
                'q_cs_qtimes_s1', 'q_cs_qtimes_s2', 
                'users'
            ));
        } elseif ($user_role == "Foreman Quality") {
            return view('quality.ipqc.foreman.index', compact(
                'q_processes', 'q_areas', 'q_models', 'q_parts', 
                // 'qualityMonitors','q_monitors', 
                'q_cs_qtimes_s1', 'q_cs_qtimes_s2', 
                'users'
            ));
        } elseif ($user_role == "Supervisor Quality") {
            return view('quality.ipqc.supervisor.index', compact(
                'q_processes', 'q_areas', 'q_models', 'q_parts', 
                // 'qualityMonitors','q_monitors', 
                'q_cs_qtimes_s1', 'q_cs_qtimes_s2', 
                'users'
            ));
        } elseif ($user_role == "Dept Head Quality") {
            return view('quality.ipqc.depthead.index', compact(
                'q_processes', 'q_areas', 'q_models', 'q_parts', 
                // 'qualityMonitors','q_monitors', 
                'q_cs_qtimes_s1', 'q_cs_qtimes_s2', 
                'users'
            ));
        } elseif ($user_role == "Director Quality") {
            return view('quality.ipqc.director.index', compact(
                'q_processes', 'q_areas', 'q_models', 'q_parts', 
                // 'qualityMonitors', 'q_monitors', 
                'q_cs_qtimes_s1', 'q_cs_qtimes_s2', 
                'users'
            ));
        } else {
            return view('quality.ipqc.index', compact(
                'q_processes', 'q_areas', 'q_models', 'q_parts', 
                // 'qualityMonitors', 
                'q_monitors', 
                'q_cs_qtimes_s1', 'q_cs_qtimes_s2', 
                'users'
            ));
        }
    }


    public function generateDocNumber() {
        do {
            $doc_number = random_int(100000, 999999);
        } while (QualityMonitor::where("doc_number", "=", "AJI/QA/".$doc_number)->first()); 
        return $doc_number;
    }

    public function generateLotProduksi() {
        // format tahun-bulan-tangga;
        // tahun, get 1 digit terakhir
        // bulan, huruf A-M
        // tanggal, 1-9 10-31(A-Y)
        // contoh 06 oktober 2022 = 2K6
        $date_now = now();
        $year = date('Y', strtotime($date_now)); 
        $month = date('m', strtotime($date_now)); 
        $date = date('d', strtotime($date_now)); 
        // dd($year);
        $year = substr($year, -1);
        $month = substr($month, -1);
        $date = substr($date, -1);

        $date_array = array('1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','I','J','K','L','M');
        $month_array = array('A','B','C','D','E','F','G','H','I','J','K','L','M');

        $tanggal = $date_array[$date-1];
        $bulan = $month_array[$month-1];
        $tahun = $year;

        return $tahun.$bulan.$tanggal;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // dependent dropdown
        // $qualityMonitors = QualityMonitor::with(['qualityArea', 'qualityProcess', 'qualityModel', 'qualityPart']);
        // $qualityMonitors = $qualityMonitors->get();

        $q_areas = QualityArea::all();
        $q_processes = QualityProcess::where("area_id",10)->get();
        $q_machines = QualityMachine::all();
        $q_models = QualityModel::all();
        $q_parts = QualityPart::all();
        // $q_monitors = QualityMonitor::all();

        // generate Lot Produksi
        // format : tahun
        $lotProduksi = $this->generateLotProduksi();
        // dd($lotProduksi);

        return view('quality.ipqc.create', compact(
            'q_processes', 'q_areas', 'q_models', 'q_parts', 'lotProduksi'
            // 'q_monitors'
        ));
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

        $q_ipqc = new QualityIpqc;
        $q_ipqc->user_id = $user_id;
        $q_ipqc->lot_produksi = $request->input('lot_produksi');
        $q_ipqc->judgement = 0;
        $q_ipqc->quality_area_id = $request->input('area_id');
        $q_ipqc->quality_process_id = $request->input('process_id');
        $q_ipqc->quality_machine_id = $request->input('machine_id');
        $q_ipqc->quality_model_id = $request->input('model_id');
        $q_ipqc->quality_part_id = $request->input('part_id');
        $q_ipqc->created_by = $user_id;
        // $q_ipqc->created_at = now();
        $q_ipqc->created_at = $request->input('datetime');

        if ($q_ipqc->save()) {
            return redirect()->route('quality.ipqc.index')->withSuccess(__('IPQC Checksheet created successfully.'));
        }else{
            return redirect()->route('quality.ipqc.index')->withSuccess(__('Maaf terjadi kesalahan. Silahkan coba kembali.'));
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
        //
    }
}
