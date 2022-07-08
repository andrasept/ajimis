<?php

namespace App\Http\Controllers;

use App\Models\Skills;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class DeliverySkillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
           
            $query = DB::table('delivery_skills');

            $query= $query->select('delivery_skills.*')->get();
            
            return DataTables::of($query)->toJson();
        }else{
           
            return view("delivery.skills.skills");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("delivery.skills.create");
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
     * @param  \App\Models\Skills  $skills
     * @return \Illuminate\Http\Response
     */
    public function show(Skills $skills)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Skills  $skills
     * @return \Illuminate\Http\Response
     */
    public function edit(Skills $skills, $id)
    {
        $data = Skills::findOrFail($id);
        return view('delivery.skills.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Skills  $skills
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Skills $skills)
    {
        $validator =  Validator::make($request->all(),[
            'skill_code' =>['required'],
            'skill' => ['required'],
            'category' => ['required'],
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }else{
            
            
            DB::beginTransaction();

            
            // proses db
            try {

                $data = Skills::findOrFail($request->id);
                $data->fill($request->all());
                $data->save();
                DB::commit();

                return redirect('/delivery/skills')->with('success', 'Skills Updated!');
            } catch (\Throwable $th) {
                // dd($th);
                DB::rollback();
                // throw $th;
                return redirect('/delivery/skills')->with('fail', "Update Skills Failed! [105]");

            }
            
           
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Skills  $skills
     * @return \Illuminate\Http\Response
     */
    public function destroy(Skills $skills, $id)
    {
        try {
            $data = Skills::findOrFail($id);
            $data->delete();
           
            return redirect('/delivery/skills')->with('success', 'Skills Deleted!');
        } catch (\Throwable $th) {
            throw $th;
            // return redirect('/delivery/skills')->with("fail","Failed Delete! [105]");
        }
    }

    public function insert(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'skill_code' =>['required','unique:delivery_skills'],
            'skill' =>['required','unique:delivery_skills'],
            'category' => ['required'],
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }else{
            DB::beginTransaction();

            try {
                Skills::create($request->all());
                DB::commit();

                return redirect('/delivery/skills')->with('success', 'Skills Added!');
            } catch (\Throwable $th) {
                DB::rollback();
                // throw $th;

                return redirect('/delivery/skills')->with('fail', "Add Skills Failed! [105]");
            }
        }
    }
}
