<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QualityArea;
use App\Models\QualityProcess;
use App\Models\QualityMachine;
use App\Models\QualityModel;
use App\Models\QualityPart;
use App\Models\QualityIpqc;
use App\Models\QualityCsIpqc;
use App\Models\QualityMonitor;
use App\Models\QualityCsQtime;
use App\Models\QualityNgCategory;

use App\Models\User;
use Illuminate\Support\Facades\DB;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;

class QualityCsIpqcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getUserRole() {
        $user = auth()->user();
        $userRoles = $user->roles()->get(); 
        // return $user->getRoleNames();

        $roles = $user->getRoleNames();
        foreach ($roles as $key => $value) {
            $role_name = $value;
        }
        return $role_name;
    }

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
        $q_areas = QualityArea::all();
        $q_processes = QualityProcess::all();
        $q_machines = QualityMachine::all();
        $q_models = QualityModel::all();
        $q_parts = QualityPart::all();
        $q_ipqcs = QualityIpqc::all();
        $q_ngcategories = QualityNgCategory::all();

        // doc number
        // $randomNumber = $this->generateDocNumber();
        // $randomNumber = (new QualityMonitorController)->generateDocNumber();

        // cs monitors
        // $q_monitors_id = DB::table('quality_monitors')->where('id', $id)->get();

        // // get cs category
        // $cs_cat_qtime = DB::table('quality_monitors')->where('id', $id)->pluck('quality_cs_qtime')->first();
        // $cs_cat_acc = DB::table('quality_monitors')->where('id', $id)->pluck('quality_cs_accuracy')->first();
        // if ($cs_cat_qtime == 1) {
        //     $cs_category = "QTime";
        // } elseif ($cs_cat_acc == 1) {
        //     $cs_category = "Accuracy";
        // } else {
        //     $cs_category = "No Category";
        // }
        // get cs doc number
        // $doc_number = DB::table('quality_monitors')->where('id', $id)->pluck('doc_number')->first();
        // lot produksi
        $lot_produksi = DB::table('quality_ipqcs')->where('id', $id)->pluck('lot_produksi')->first();
        // get area
        $cs_area = DB::table('quality_ipqcs')->where('id', $id)->pluck('quality_area_id')->first();
        $cs_area = DB::table('quality_areas')->where('id', $cs_area)->pluck('name')->first();
        // echo $cs_area; exit();
        // get process
        $cs_process = DB::table('quality_ipqcs')->where('id', $id)->pluck('quality_process_id')->first();
        $cs_process = DB::table('quality_processes')->where('id', $cs_process)->pluck('name')->first();
        // get machine
        $cs_machine = DB::table('quality_ipqcs')->where('id', $id)->pluck('quality_machine_id')->first();
        $cs_machine = DB::table('quality_machines')->where('id', $cs_machine)->pluck('name')->first();
        // get model
        $cs_model = DB::table('quality_ipqcs')->where('id', $id)->pluck('quality_model_id')->first();
        $cs_model = DB::table('quality_models')->where('id', $cs_model)->pluck('name')->first();
        // get part
        $cs_part_id = DB::table('quality_ipqcs')->where('id', $id)->pluck('quality_part_id')->first();   
        $cs_part = DB::table('quality_ipqcs')->where('id', $id)->pluck('quality_part_id')->first();   
        $cs_part = DB::table('quality_parts')->where('id', $cs_part)->pluck('name')->first();   
        // get photo part
        $cs_part_photo_id = DB::table('quality_ipqcs')->where('id', $id)->pluck('quality_part_id')->first(); 
        $cs_photo = DB::table('quality_parts')->where('id', $cs_part_photo_id)->pluck('photo')->first();
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

        $q_ipqc_id = $id;

        // kondisional jika di part horizontal terdapat yg low, maka pindahkan form ke yg low, dst


        return view('quality.csipqc.create', compact(
            'q_areas','q_processes', 'q_machines', 'q_models', 'q_parts', 
            'q_ipqcs', 'lot_produksi', 'cs_area', 'cs_process', 'cs_machine', 'cs_model', 'cs_part', 'part_ver', 'part_hor', 'cs_photo',
            'q_ipqc_id', 'q_ngcategories'
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
        $user_name = auth()->user()->name;

        // insert cs qtime untuk cs low
        $q_cs_ipqcs = new QualityCsIpqc;
        $q_cs_ipqcs->quality_ipqc_id = $request->input('quality_ipqc_id');
        $q_cs_ipqcs->shift = $request->input('shift');
        $q_cs_ipqcs->cycle = $request->input('cycle');

        $q_cs_ipqcs->destructive_test = $request->input('destructive_test');
        $q_cs_ipqcs->destructive_test_remark = $request->input('destructive_test_remark');
        $q_cs_ipqcs->destructive_test_hold_status = $request->input('destructive_test_hold_status');
        $q_cs_ipqcs->destructive_test_qty = $request->input('destructive_test_qty');
        $q_cs_ipqcs->destructive_test_hold_cat = $request->input('destructive_test_hold_cat');

        $q_cs_ipqcs->appearance_produk = $request->input('appearance_produk');
        $q_cs_ipqcs->appearance_produk_remark = $request->input('appearance_produk_remark');
        $q_cs_ipqcs->appearance_produk_ng_cat = $request->input('appearance_produk_ng_cat');
        $q_cs_ipqcs->appearance_produk_photo = $request->input('appearance_produk_photo');
        $q_cs_ipqcs->appearance_produk_causes = $request->input('appearance_produk_causes');
        $q_cs_ipqcs->appearance_produk_repair = $request->input('appearance_produk_repair');
        $q_cs_ipqcs->appearance_produk_repair_res = $request->input('appearance_produk_repair_res');
        $q_cs_ipqcs->appearance_produk_hold_status = $request->input('appearance_produk_hold_status');
        $q_cs_ipqcs->appearance_produk_qty = $request->input('appearance_produk_qty');
        $q_cs_ipqcs->appearance_produk_hold_cat = $request->input('appearance_produk_hold_cat');

        $q_cs_ipqcs->parting_line = $request->input('parting_line');
        $q_cs_ipqcs->parting_line_remark = $request->input('parting_line_remark');
        $q_cs_ipqcs->parting_line_ng_cat = $request->input('parting_line_ng_cat');
        $q_cs_ipqcs->parting_line_photo = $request->input('parting_line_photo');
        $q_cs_ipqcs->parting_line_causes = $request->input('parting_line_causes');
        $q_cs_ipqcs->parting_line_repair = $request->input('parting_line_repair');
        $q_cs_ipqcs->parting_line_repair_res = $request->input('parting_line_repair_res');
        $q_cs_ipqcs->parting_line_hold_status = $request->input('parting_line_hold_status');
        $q_cs_ipqcs->parting_line_qty = $request->input('parting_line_qty');
        $q_cs_ipqcs->parting_line_hold_cat = $request->input('parting_line_hold_cat');

        $q_cs_ipqcs->marking_cek_final = $request->input('marking_cek_final');
        $q_cs_ipqcs->marking_cek_final_remark = $request->input('marking_cek_final_remark');
        $q_cs_ipqcs->marking_garansi_function = $request->input('marking_garansi_function');
        $q_cs_ipqcs->marking_garansi_function_remark = $request->input('marking_garansi_function_remark');
        $q_cs_ipqcs->marking_identification = $request->input('marking_identification');
        $q_cs_ipqcs->marking_identification_remark = $request->input('marking_identification_remark');

        // Kelengkapan Komponen
        $q_cs_ipqcs->kelengkapan_komponen = $request->input('kelengkapan_komponen');
        $q_cs_ipqcs->kelengkapan_komponen_remark = $request->input('kelengkapan_komponen_remark');
        $q_cs_ipqcs->kelengkapan_komponen_hold_status = $request->input('kelengkapan_komponen_hold_status');
        $q_cs_ipqcs->kelengkapan_komponen_qty = $request->input('kelengkapan_komponen_qty');
        $q_cs_ipqcs->kelengkapan_komponen_hold_cat = $request->input('kelengkapan_komponen_hold_cat');
        
        // komponen dihilangkan

        // Line Process dipindahkan ke fomr checksheet Audit

        $q_cs_ipqcs->created_by = $user_id;
        $q_cs_ipqcs->updated_by = $user_id;

        // judge di cycle 1 OK jika semua OK, jika ada NG maka NG, jika ada AC maka tunggu dulu sampai approval nya judge ??
        // apakah harus tambah column destructive_judge_1 utk cycle 1 dan destructive_judge_2 utk cycle 2 


        // checksheet category
        // $cs_cat = $request->input('quality_cs');
        // if ($cs_cat == 1) {
        //     $q_cs_ipqcs->quality_cs_qtime = 1;
        // } elseif ($cs_cat == 2) {
        //     $q_cs_ipqcs->quality_cs_accuracy = 1;
        // }

        // judge
        // cek jika ada NG
        $acng = array(
            $q_cs_ipqcs->destructive_test, 
            $q_cs_ipqcs->appearance_produk, 
            $q_cs_ipqcs->parting_line,
            $q_cs_ipqcs->marking_cek_final,
            $q_cs_ipqcs->marking_garansi_function,
            $q_cs_ipqcs->marking_identification,
            $q_cs_ipqcs->kelengkapan_komponen
        );
        if (in_array("3", $acng)) {
            $q_cs_ipqcs->judge = 3;
        } elseif(in_array("2", $acng)) {
            $q_cs_ipqcs->judge = 2;
        } elseif(in_array("1", $acng)) {
            $q_cs_ipqcs->judge = 1;
        } else {
            $q_cs_ipqcs->judge = 0;
        }


        if ($q_cs_ipqcs->save()) {
            // DONE judge di cycle 1 OK jika semua OK, jika ada NG maka NG, jika ada AC maka tunggu dulu sampai approval nya judge ??
            // DONE apakah harus tambah column destructive_judge_1 utk cycle 1 dan destructive_judge_2 utk cycle 2 
            // DONE apakah harus disimpan disini, agar bisa query update jika ada yg NG

            // last insert id
            $last_cs_ipqc_id = DB::getPdo()->lastInsertId();
            $last_insert_id = $last_cs_ipqc_id;

            if (in_array("3", $acng)) {
                $q_cs_ipqcs->judge = 3;
                // lanjut notif NG ke Telegram : ada NG di No. Checksheet QTime ABC | Part and Model ABC | Area ABC | Atas Nama Member ABC
                // send notif telegram
                $user_role = $this->getUserRole();
                $cs_ipqc = QualityIpqc::find($request->input('quality_ipqc_id'));
                $message = 'Ada NG di Checksheet IPQC - '.$cs_ipqc->lot_produksi.chr(10);
                $message .= '[Nama Part] - Model [Nama Model]'.chr(10);
                $message .= '[Area] - Member [Nama Member]'.chr(10);
                $this->sendTelegram('-793766953',$message );

                // lanjut Approval NG ke Leader
                // set cs_status "Waiting Approval" di tabel q_ipqcs
                $quality_ipqc_id = $request->input('quality_ipqc_id');
                DB::table('quality_ipqcs')->where('id', $quality_ipqc_id)->update([
                    'cs_status' => 1,
                    'updated_at' => now(),
                    'updated_by' => $user_id
                ]);

                // DB::enableQueryLog();
                // set approval_status berjenjang di tabel q_cs_ipqcs, pertama ke Leader dahulu dan atau seterusnya
                // Request approval ke Leader
                DB::table('quality_cs_ipqcs')->where('id', $last_insert_id)->update([
                    'approval_status' => 1,
                    'updated_at' => now(),
                    'updated_by' => $user_id
                ]);
                // $query_print = DB::table('quality_cs_ipqcs')->where('id', $last_insert_id)->update(['approval_status' => 1]);
                // dd($query_print); exit();


                // setelah approval_status = 6 (selesai), maka kolom judge di tabel cs_qtimes berubah sesuai dengan action dari approver
                // judgement di tabel quality_ipqcs pun ter update

                // LANJUT UPDATE STATUS KOLOM JUDGEMENT
                // kondisi OK
                // kondisi NG

            } elseif(in_array("2", $acng)) {
                $q_cs_ipqcs->judge = 2;
                // lanjut notif approval ACceptance ke leader dst
                // cs status = approval AC ke leader dst
                // judgment collect dari tiap cycle, lalu update

                // set cs_status "Waiting Approval" di tabel q_ipqcs
                $quality_ipqc_id = $request->input('quality_ipqc_id');
                DB::table('quality_ipqcs')->where('id', $quality_ipqc_id)->update([
                    'cs_status' => 1,
                    'updated_at' => now(),
                    'updated_by' => $user_id
                ]);
                // set approval_status berjenjang di tabel q_cs_ipqcs, pertama ke Leader dahulu dan atau seterusnya
                // Request approval ke Leader
                DB::table('quality_cs_ipqcs')->where('id', $last_insert_id)->update([
                    'approval_status' => 1
                    // 'updated_at' => now(),
                    // 'updated_by' => $user_id
                ]);

            } elseif(in_array("1", $acng)) {
                $q_cs_ipqcs->judge = 1;
            } else {
                $q_cs_ipqcs->judge = 0;
            }


            // LANJUT
            // LANJUT view detail di tabel ipqcs
            // LANJUT view approval Leader
            // LANJUT view approval Foreman
            // LANJUT



            // Kirim notif ke Telegram

            return redirect()->route('quality.ipqc.index')->withSuccess(__('Monitor IPQC created successfully.'));
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
        $cs_qtime_id = $id;
        // get monitor_id
        // get quality_monitor_id from $id
        $monitor_id = DB::table('quality_cs_qtimes')->where('id', $id)->pluck('quality_monitor_id')->first();
        // echo $monitor_id; exit();
        $id = $monitor_id;
        // echo $cs_qtime_id; exit();

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

        // show quality_cs_qtimes
        $q_cs_qtimes = DB::table('quality_cs_qtimes')->where('id', $cs_qtime_id)->get();
        // dd($q_cs_qtimes);


        return view('quality.csqtime.leader.edit', compact(
            'q_processes', 'q_areas', 'q_models', 'q_parts', 'qualityMonitors', 'randomNumber', 'q_monitors', 
            'cs_category', 'doc_number', 'cs_area', 'cs_process', 'cs_model', 'cs_part', 'part_ver', 'part_hor',
            'q_monitor_id',
            'q_cs_qtimes', 'cs_qtime_id'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    // public function update(Request $request, QualityCsQtime $id)
    {
        $user_id = auth()->user()->id;
        $cs_qtime_id = $id;
        $q_monitor_id = $request->quality_monitor_id;
        // echo $cs_qtime_id; exit();

        $csqtime['quality_monitor_id'] = $request->quality_monitor_id;
        $csqtime['destructive_test'] = $request->destructive_test;
        $csqtime['destructive_test_remark'] = $request->destructive_test_remark;
        $csqtime['appearance_produk'] = $request->appearance_produk;
        $csqtime['appearance_produk_remark'] = $request->appearance_produk_remark;
        $csqtime['parting_line'] = $request->parting_line;
        $csqtime['parting_line_remark'] = $request->parting_line_remark;
        $csqtime['marking_cek_final'] = $request->marking_cek_final;
        $csqtime['marking_cek_final_remark'] = $request->marking_cek_final_remark;
        $csqtime['marking_garansi_function'] = $request->marking_garansi_function;
        $csqtime['marking_garansi_function_remark'] = $request->marking_garansi_function_remark;
        $csqtime['marking_identification'] = $request->marking_identification;
        $csqtime['marking_identification_remark'] = $request->marking_identification_remark;
        $csqtime['kelengkapan_komponen'] = $request->kelengkapan_komponen;
        $csqtime['kelengkapan_komponen_remark'] = $request->kelengkapan_komponen_remark;
        // update last judge by dan last judge at
        $csqtime['updated_by'] = $user_id;
        $csqtime['updated_at'] = now();
        // dd($csqtime); exit();

        // // cek judgement, panggil fungsi judgement getJudgementStatus()
        // $judgement = $this->getJudgementStatus($q_monitor_id, $cs_qtime_id);
        // // DB::table('quality_monitors')->where('id', $q_monitor_id)->update(['judgement' => $judgement]);
        // echo $judgement;
        // exit();   

        // LANJUT STATUS HARUS TERUPDATE JUGA, AGAR DI DETAIL MODAL WINDOW TERUPDATE JUGA
        // kondisional submit
        if (isset($_POST['submit_ac'])) {
            // jika di-ACceptance 
            // update cs_status Waiting Approval di tabel q_monitors
            DB::table('quality_monitors')->where('id', $q_monitor_id)->update(['cs_status' => 1]);
            // update judge dan approval_status di tabel q_cs_qtimes
            // update judge
            $acng = array(
                $request->destructive_test, 
                $request->appearance_produk, 
                $request->parting_line,
                $request->marking_cek_final,
                $request->marking_garansi_function,
                $request->marking_identification,
                $request->kelengkapan_komponen
            );
            if (in_array("3", $acng)) {
                $request->judge = 3;
                $csqtime['judge'] = $request->judge;
            } elseif(in_array("2", $acng)) {
                $request->judge = 2;
                $csqtime['judge'] = $request->judge;
            } elseif(in_array("1", $acng)) {
                $request->judge = 1;
                $csqtime['judge'] = $request->judge;
            } else {
                $request->judge = 0;
                $csqtime['judge'] = $request->judge;
            }
            // update approval_status
            // DB::table('quality_cs_qtimes')->where('id', $cs_qtime_id)->update(['approval_status' => 6]);
            // approval level
            $user_role = $this->getUserRole();
            if ($user_role == "User Quality") {
                $csqtime['approval_status'] = 1;
            } elseif ($user_role == "Leader Quality") {
                $csqtime['approval_status'] = 2;
            } elseif ($user_role == "Foreman Quality") {
                $csqtime['approval_status'] = 3;
            } elseif ($user_role == "Supervisor Quality") {
                $csqtime['approval_status'] = 4;
            } elseif ($user_role == "Dept Head Quality") {
                $csqtime['approval_status'] = 5;
            } elseif ($user_role == "Director Quality") {
                $csqtime['approval_status'] = 6;
            }            

            // update judgement di tabel q_monitors

            // kasih stamp approved by jenjang leader-director di page edit
        } elseif (isset($_POST['submit_app'])) {
            // jika di-approved 
            // update cs_status approved by Leader di tabel q_monitors
            // harusnya cek dahulu approval di setiap cs_qtime_id nya, jika sudah approved semua baru cs_status = 2, jika belum cs_status = 1
            DB::table('quality_monitors')->where('id', $q_monitor_id)->update(['cs_status' => 2]);

            // update judge dan approval_status di tabel q_cs_qtimes
            // update judge
            $acng = array(
                $request->destructive_test, 
                $request->appearance_produk, 
                $request->parting_line,
                $request->marking_cek_final,
                $request->marking_garansi_function,
                $request->marking_identification,
                $request->kelengkapan_komponen
            );
            if (in_array("3", $acng)) {
                $request->judge = 3;
                $csqtime['judge'] = $request->judge;
            } elseif(in_array("2", $acng)) {
                $request->judge = 2;
                $csqtime['judge'] = $request->judge;
            } elseif(in_array("1", $acng)) {
                $request->judge = 1;
                $csqtime['judge'] = $request->judge;
            } else {
                $request->judge = 0;
                $csqtime['judge'] = $request->judge;
            }
            // update approval_status
            // DB::table('quality_cs_qtimes')->where('id', $cs_qtime_id)->update(['approval_status' => 6]);
            $csqtime['approval_status'] = 6;
            // update judgement di tabel q_monitors

            // kasih stamp approved by jenjang leader-director di page edit

            // send notif telegram
            $user_role = $this->getUserRole();
            $message=$user_role.' sudah approve'.chr(10);
            $this->sendTelegram('-793766953',$message );
        }
        // cek judgement, panggil fungsi judgement getJudgementStatus(), lalu update kolom judgment
        $judgement = $this->getJudgementStatus($q_monitor_id, $cs_qtime_id);
        // echo $judgement;
        DB::table('quality_monitors')->where('id', $q_monitor_id)->update(['judgement' => $judgement]);
        // exit();     
        // LANJUT DI SINI 20220704, TESTING UPDATE, LALU LANJUT BUAT LEVELING (pakai get role di qmonitor view) APPROVAL PAGE UNTUK FOREMAN UP

        QualityCsQtime::find($id)->update($csqtime);
        return redirect()->route('quality.monitor.index')
            ->withSuccess(__('Checksheet updated successfully.'));
    }

    public function getJudgementStatus($q_monitor_id, $cs_qtime_id) {
        // get cs status sudah finish cs_status = 3
        $cs_statuses = DB::table('quality_monitors')->where('id', $q_monitor_id)
            // ->where('cs_status', 3)
            ->pluck('cs_status');
        foreach ($cs_statuses as $key => $value) {
            $cs_status = $value;
        }

        // jika cs_status sudah finish
        if ($cs_status == 3) {
            // get judge AC/NG di shift 1
            $judge_status_s1 = DB::table('quality_cs_qtimes')
                ->where('quality_monitor_id', $q_monitor_id)
                ->where('shift', 1)->pluck('judge')->toArray();
                // ->where('shift', 1)->get();
            // dd($judge_status_s1); exit();
            // cek jika ada AC/NG
            if (in_array("3", $judge_status_s1)) {
                $judgement_1 = 2;
            } elseif(in_array("2", $judge_status_s1)) {
                $judgement_1 = 2;
            } elseif(in_array("1", $judge_status_s1)) {
                $judgement_1 = 1;
            } else {
                $judgement_1 = 0;
            }

            // get judge AC/NG di shift 2
            $judge_status_s2 = DB::table('quality_cs_qtimes')
                ->where('quality_monitor_id', $q_monitor_id)
                ->where('shift', 2)->pluck('judge')->toArray();
            // cek jika ada AC/NG
            if (in_array("3", $judge_status_s2)) {
                $judgement_2 = 2;
            } elseif(in_array("2", $judge_status_s2)) {
                $judgement_2 = 2;
            } elseif(in_array("1", $judge_status_s2)) {
                $judgement_2 = 1;
            } else {
                $judgement_2 = 0;
            }

            // judgement jika cs_status = 3 dan tidak ada AC/NG di kedua shift = OK, else NG
            $judgement_arr = array($judgement_1, $judgement_2);
            // dd($judgement_arr); exit();
            if (in_array("3", $judgement_arr)) {
                $judgement = 2;
            } elseif(in_array("2", $judgement_arr)) {
                $judgement = 2;
            } elseif(in_array("1", $judgement_arr)) {
                $judgement = 1;
            } else {
                $judgement = 0;
            }

            return $judgement;
        } else {
            $judgement = 0;
            return $judgement;
        }
        
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

    public function sendTelegram($chat_id, $text)
    {
        $token ='5316703664:AAGkWlsG2nDe1eIQtrTN_OYlYaXluxSGuCU';
        // ddd($text);
        // $text = urlencode($text);
        $params=[
            'parse_mode'=>'html',
            'chat_id'=>$chat_id, 
            'text'=>$text,
        ];
        // $url = 'https://api.telegram.org/bot'.$token.'/sendMessage/';
        try {
            file_get_contents('https://api.telegram.org/bot'.$token.'/sendMessage?'.http_build_query($params));
        } catch (\Throwable $th) {
            //throw $th;
        }
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_POST, 0);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // $response = curl_exec ($ch);
        // $err = curl_error($ch); 
        // curl_close ($ch);
    }

    public function cycleNgCheck($q_monitor_id, $cs_qtime_id) {
        // tomboll "add cycle" dikunci dahulu sampai ada action dan approved, approval_status=6
        
    }
    
}
