<?php

namespace App\Http\Controllers;

use App\Models\Skills;
use Illuminate\Http\Request;
use App\Models\ManPowerDelivery;
use App\Imports\SkillMatrixImport;
use Illuminate\Support\Facades\DB;
use App\Models\SkillMatrixDelivery;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class DeliverySkillMatrixController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = DB::table('delivery_man_powers')->whereIn('npk',function($query) {

                $query->select('user_id')->from('delivery_matrix_skills');
             
             });

            $query= $query->select('delivery_man_powers.npk','delivery_man_powers.name','delivery_man_powers.position','delivery_man_powers.photo')->get()->unique();

            return DataTables::of($query)->toJson();
        }else{
            return view("delivery.skillsmatrix.index");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = DB::table('delivery_skills')->pluck('category')->unique();

        $list_skill_each_category = [];
        $list_categories = [];
        foreach ($categories as $category) {
            $array = Skills::select("skill_code","category")
            ->where("category", $category)->get();
            array_push($list_skill_each_category , $array); 
            array_push($list_categories, $category);
        }   
        $mps = DB::table('delivery_man_powers')->whereNotIn('npk',function($query) {

            $query->select('user_id')->from('delivery_matrix_skills');
         
         })->get();
        return view("delivery.skillsmatrix.create", compact('mps','list_skill_each_category','list_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // untuk import excel 
        if ($request->hasFile('skill-matrix-excel')) {
            // data import dari excel
            $data = Excel::toArray(new SkillMatrixImport, request()->file('skill-matrix-excel'));
            for ($i=0; $i < count($data[0]); $i++) { 
                // id mp yg akan diisi skill value
                $data[0][$i][3] =  $request->user_id;
            }
            // dd($data);
            $validator = Validator::make($data[0], [
                '*.0' => ['required'],
                '*.1' =>  ['required'],
                '*.2' =>  ['required'],
                '*.3' =>  ['required'],
               
            ]);
            
            if ($validator->fails()) {

                $errors = $validator->errors()->all();
                foreach ($errors as $key => $error) {
                    $num =(int)preg_replace('/[^0-9]/', '', $error)+2;
                    $err_message = explode(".",$error)[1];
                    $errors[$key] = "Line (".$num.") $err_message";
                }

                return redirect('/delivery/skillmatrix')->with('fail', "Export Failed! Because:".implode(", ",$errors));
                
            }else{

                DB::beginTransaction();

                try {
                    $proses = collect(head($data))->each(function ($row, $key) {

                        SkillMatrixDelivery::Create(
                            [
                                'user_id' => $row[3],
                                'skill_id' => $row[0],
                                'value' => $row[2],
                                'category' => $row[1],
                            ]
                        );
                            
                    });

                    DB::commit();

                } catch (\Throwable $th) {

                    DB::rollback();
                    return redirect('/delivery/skillmatrix')->with('fail', "Export Failed! [105]");
                }
                    
                return redirect('/delivery/skillmatrix')->with('success', 'Export Succeed!');

            }
               
           

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SkillMatrixDelivery  $skillMatrixDelivery
     * @return \Illuminate\Http\Response
     */
    public function show(SkillMatrixDelivery $skillMatrixDelivery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SkillMatrixDelivery  $skillMatrixDelivery
     * @return \Illuminate\Http\Response
     */
    public function edit(SkillMatrixDelivery $skillMatrixDelivery, $npk)
    {
        $npk = $npk;

        $categories = DB::table('delivery_matrix_skills')->pluck('category')->unique();

        $list_skill_each_category = [];
        $list_categories = [];
        foreach ($categories as $category) {
            $array = SkillMatrixDelivery::select("skill_id","category","value")
            ->where("category", $category)->where('user_id', $npk)->get();
            array_push($list_skill_each_category , $array); 
            array_push($list_categories, $category);
        }  


        $skillmatrix = SkillMatrixDelivery::where('user_id', $npk)->get();

        $data_di_matrix = [];
        foreach($skillmatrix as $object)
        {
            $data_di_matrix[] = $object->skill_id;
        }

        $diff_skills = DB::table('delivery_skills')->select('skill_code','category')->whereNotIn('skill_code',$data_di_matrix)->get();

        $mps = DB::table('delivery_man_powers')->whereIn('npk',function($query) {

            $query->select('user_id')->from('delivery_matrix_skills');
         
         })->get();
        return view("delivery.skillsmatrix.edit", compact('mps', 'list_skill_each_category', 'npk','diff_skills','list_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SkillMatrixDelivery  $skillMatrixDelivery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SkillMatrixDelivery $skillMatrixDelivery)
    {
        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                foreach ($request->data as $key) {
                    
                    # code...
                    $skill = SkillMatrixDelivery::updateOrCreate(
                        ['user_id' => $key['user_id'],
                        'skill_id' => $key['skill_id']
                        ], [
                            'user_id' => $key['user_id'],
                            'skill_id' => $key['skill_id'],
                            'value' => $key['value']
                        ]
                    );
                    
                }
                DB::commit();
                // update or create
                if ($skill->wasRecentlyCreated) {
                    return '1';
                }else{
                    return '2';
                }
                
            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;

                // return  $th->getMessage();
            }
            
        } else {
            # code...
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SkillMatrixDelivery  $skillMatrixDelivery
     * @return \Illuminate\Http\Response
     */
    public function destroy(SkillMatrixDelivery $skillMatrixDelivery, $npk)
    {
        try {
            $data = SkillMatrixDelivery::where('user_id', $npk)->delete();
           
            return redirect('/delivery/skillmatrix')->with('success', 'Skill Matrix Deleted!');
        } catch (\Throwable $th) {
            // throw $th;
            return redirect('/delivery/skillmatrix')->with("fail","Failed Delete! [105]");
        }
    }

    public function insert(SkillMatrixDelivery $skillMatrixDelivery, Request $request)
    {
        
            if ($request->ajax()) {
                DB::beginTransaction();
                try {
                    foreach ($request->data as $key) {
                        
                        # code...
                        $skill = SkillMatrixDelivery::updateOrCreate(
                            ['user_id' => $key['user_id'],
                            'skill_id' => $key['skill_id']
                            ], [
                                'user_id' => $key['user_id'],
                                'skill_id' => $key['skill_id'],
                                'category' => $key['category'],
                                'value' => $key['value']
                            ]
                        );
                        
                    }
                    DB::commit();
                    if ($skill->wasRecentlyCreated) {
                        return '1';
                    }else{
                        return '2';
                    }
                    
                } catch (\Throwable $th) {
                    DB::rollback();
                    // throw $th;

                    return  $th->getMessage();
                }
                
            } else {
                # code...
            }
            
        
    }

    public function get_data_skillmatrix(Request $request)
    {
        $categories = Skills::pluck('category')->unique();
        
        $data= [];
        
        foreach ($categories as $category ) {
            $array = SkillMatrixDelivery::select("delivery_matrix_skills.*", "delivery_skills.category")
            ->leftjoin("delivery_skills","delivery_skills.skill_code", "=", "delivery_matrix_skills.skill_id")
            ->where("delivery_skills.category", $category)->where("user_id", $request->npk)->get();
            array_push($data, $array);
        }

        return $data;
    }
}
