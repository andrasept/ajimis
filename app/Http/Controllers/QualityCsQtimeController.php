<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QualityArea;
use App\Models\QualityProcess;
use App\Models\QualityModel;
use App\Models\QualityPart;
use App\Models\QualityMonitor;
use App\Models\QualityCsQtime;
use Illuminate\Support\Facades\DB;

class QualityCsQtimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        // echo $id; exit();
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
        // $randomNumber = $this->generateDocNumber();
        $randomNumber = (new QualityMonitorController)->generateDocNumber();

        // cs monitors
        // $q_monitors_id = DB::table('quality_monitors')->where('id', $id)->get();

        // get cs category
        $cs_cat_qtime = DB::table('quality_monitors')->where('id', $id)->pluck('quality_cs_qtime')->first();
        $cs_cat_acc = DB::table('quality_monitors')->where('id', $id)->pluck('quality_cs_accuracy')->first();
        if ($cs_cat_qtime == 1) {
            $cs_category = "QTime";
        } elseif ($cs_cat_acc == 1) {
            $cs_category = "Accuracy";
        } else {
            $cs_category = "No Category";
        }
        // get cs doc number
        $doc_number = DB::table('quality_monitors')->where('id', $id)->pluck('doc_number')->first();
        // get area
        $cs_area = DB::table('quality_monitors')->where('id', $id)->pluck('quality_area_id')->first();
        $cs_area = DB::table('quality_areas')->where('id', $cs_area)->pluck('name')->first();
        // echo $cs_area; exit();
        // get process
        $cs_process = DB::table('quality_monitors')->where('id', $id)->pluck('quality_process_id')->first();
        $cs_process = DB::table('quality_processes')->where('id', $cs_process)->pluck('name')->first();
        // get model
        $cs_model = DB::table('quality_monitors')->where('id', $id)->pluck('quality_model_id')->first();
        $cs_model = DB::table('quality_models')->where('id', $cs_model)->pluck('name')->first();
        // get part
        $cs_part_id = DB::table('quality_monitors')->where('id', $id)->pluck('quality_part_id')->first();   
        $cs_part = DB::table('quality_monitors')->where('id', $id)->pluck('quality_part_id')->first();   
        $cs_part = DB::table('quality_parts')->where('id', $cs_part)->pluck('name')->first();   
        // get part vertical
        $cs_part_ver = DB::table('quality_parts')->where('id', $cs_part_id)->get();
        foreach($cs_part_ver as $cpv) {
            if ($cpv->low) {
                $part_ver = "Low";
            } elseif ($cpv->mid) {
                $part_ver = "Mid";
            } elseif ($cpv->high) {
                $part_ver = "High";
            } else {
                $part_ver = "";
            }
        }
        // get part horizontal
        $cs_part_hor = DB::table('quality_parts')->where('id', $cs_part_id)->get();
        foreach($cs_part_hor as $cph) {
            if ($cph->left) {
                $part_hor = "Left";
            } elseif ($cph->center) {
                $part_hor = "Center";
            } elseif ($cph->right) {
                $part_hor = "Right";
            } else {
                $part_hor = "";
            }
        }

        $q_monitor_id = $id;

        // kondisional jika di part horizontal terdapat yg low, maka pindahkan form ke yg low, dst


        return view('quality.csqtime.create', compact(
            'q_processes', 'q_areas', 'q_models', 'q_parts', 'qualityMonitors', 'randomNumber', 'q_monitors', 
            'cs_category', 'doc_number', 'cs_area', 'cs_process', 'cs_model', 'cs_part', 'part_ver', 'part_hor',
            'q_monitor_id'
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

        // insert cs qtime untuk cs low
        $q_cs_qtimes = new QualityCsQtime;
        $q_cs_qtimes->quality_monitor_id = $request->input('quality_monitor_id');
        $q_cs_qtimes->shift = $request->input('shift');
        $q_cs_qtimes->cycle = $request->input('cycle');

        $q_cs_qtimes->destructive_test = $request->input('destructive_test');
        $q_cs_qtimes->appearance_produk = $request->input('appearance_produk');
        $q_cs_qtimes->parting_line = $request->input('parting_line');

        $q_cs_qtimes->marking_cek_final = $request->input('marking_cek_final');
        $q_cs_qtimes->marking_garansi_function = $request->input('marking_garansi_function');
        $q_cs_qtimes->marking_identification = $request->input('marking_identification');

        $q_cs_qtimes->housing = $request->input('housing');
        $q_cs_qtimes->lens = $request->input('lens');
        $q_cs_qtimes->extension = $request->input('extension');
        $q_cs_qtimes->reflector_1 = $request->input('reflector_1');
        $q_cs_qtimes->reflector_2 = $request->input('reflector_2');
        $q_cs_qtimes->ldm = $request->input('ldm');
        $q_cs_qtimes->wire_harness_2 = $request->input('wire_harness_2');
        $q_cs_qtimes->wire_harness_3 = $request->input('wire_harness_3');
        $q_cs_qtimes->wire_harness_4 = $request->input('wire_harness_4');
        $q_cs_qtimes->wire_harness_5 = $request->input('wire_harness_5');
        $q_cs_qtimes->pcb_assy_2 = $request->input('pcb_assy_2');
        $q_cs_qtimes->pcb_assy_3 = $request->input('pcb_assy_3');
        $q_cs_qtimes->gore_tag = $request->input('gore_tag');
        $q_cs_qtimes->tapping_screw = $request->input('tapping_screw');
        $q_cs_qtimes->tapping_screw_assy = $request->input('tapping_screw_assy');
        $q_cs_qtimes->screw_pin = $request->input('screw_pin');
        $q_cs_qtimes->non_woven_tape = $request->input('non_woven_tape');
        $q_cs_qtimes->vent_cap_assy = $request->input('vent_cap_assy');

        $q_cs_qtimes->kondisi_jig = $request->input('kondisi_jig');
        $q_cs_qtimes->kondisi_pokayoke = $request->input('kondisi_pokayoke');
        $q_cs_qtimes->operator_wi_qpoint = $request->input('operator_wi_qpoint');
        $q_cs_qtimes->childpart_identitas = $request->input('childpart_identitas');
        $q_cs_qtimes->kondisi_parameter = $request->input('kondisi_parameter');

        $q_cs_qtimes->created_by = $user_id;

        // judge di cycle 1 OK jika semua OK, jika ada NG maka NG, jika ada AC maka tunggu dulu sampai approval nya judge ??
        // apakah harus tambah column destructive_judge_1 utk cycle 1 dan destructive_judge_2 utk cycle 2 


        // checksheet category
        // $cs_cat = $request->input('quality_cs');
        // if ($cs_cat == 1) {
        //     $q_cs_qtimes->quality_cs_qtime = 1;
        // } elseif ($cs_cat == 2) {
        //     $q_cs_qtimes->quality_cs_accuracy = 1;
        // }

        if ($q_cs_qtimes->save()) {
            // judge di cycle 1 OK jika semua OK, jika ada NG maka NG, jika ada AC maka tunggu dulu sampai approval nya judge ??
            // apakah harus tambah column destructive_judge_1 utk cycle 1 dan destructive_judge_2 utk cycle 2 
            // apakah harus disimpan disini, agar bisa query update jika ada yg NG


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
        //
    }
}
