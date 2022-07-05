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
            'skill_code' =>['required','unique:delivery_skills'],
            'skill' => ['required','unique:delivery_skills'],
            'category' => ['required'],
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }else{
            
            if ($request->evidence == [] && $request->photo == []) {
                return redirect('/delivery/claim')->with('fail', "Evidence cannot empty!");
            } else {
                DB::beginTransaction();
            
                // delete evidence existing
                try {
                    foreach ($request->delete as $key) {
                        Storage::disk('public')->delete('/delivery-claim-photo/'.$key);
                    }
                } catch (\Throwable $th) {
                    //throw $th;
                }


                // proses uplaod image evidence
                $data = [];

                if ($request->hasFile('photo')) {
                
                    // memasukan data evidence baru ke array baru
                    foreach ($request->file('photo') as $photo) {
                        $name= $photo->hashName();
                        $photo->store('delivery-claim-photo');
                        array_push($data, $name); 
                    }
                    
                }
                
                // proses db
                try {
                    // masukan evidence existing ke array baru
                    if ($request->evidence == []) {
                       
                    }else{
                        foreach ($request->evidence as $key) {
                            array_push($data, $key); 
                        }
                    }
                    // overwrite request
                    $request->request->add(['evidence' =>  $data]);
                    $img_names = $request->evidence;
                    $img_names =implode(",", $img_names);
                    $request->merge(["evidence"=>$img_names]);

                    $data = DeliveryClaim::findOrFail($request->id);
                    $data->fill($request->all());
                    $data->save();
                    DB::commit();

                    return redirect('/delivery/claim')->with('success', 'Claim Updated!');
                } catch (\Throwable $th) {
                    // dd($th);
                    DB::rollback();
                    // throw $th;
                    return redirect('/delivery/claim')->with('fail', "Update Claim Failed! [105]");

                }
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
