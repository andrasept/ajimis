<?php

namespace App\Http\Controllers;

use App\Models\Skills;
use Illuminate\Http\Request;
use App\Models\ManPowerDelivery;
use Illuminate\Support\Facades\DB;
use App\Models\SkillMatrixDelivery;
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
        $skills = Skills::all();
        $mps = DB::table('delivery_man_powers')->whereNotIn('npk',function($query) {

            $query->select('user_id')->from('delivery_matrix_skills');
         
         })->get();
        return view("delivery.skillsmatrix.create", compact('skills','mps'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $skills = Skills::all();
        $diff_skills = DB::table('delivery_skills')->whereNotIn('skill_code',function($query) {
            global $npk;
            $query->select('skill_id')->where('user_id', $npk)->from('delivery_matrix_skills');
         
         })->get();
        $skillmatrix = SkillMatrixDelivery::where('user_id', $npk)->get();
        $npk = $npk;
        $mps = DB::table('delivery_man_powers')->whereIn('npk',function($query) {

            $query->select('user_id')->from('delivery_matrix_skills');
         
         })->get();
        return view("delivery.skillsmatrix.edit", compact('skills','mps', 'skillmatrix', 'npk','diff_skills'));
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
