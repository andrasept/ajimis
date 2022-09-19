<?php

namespace App\Http\Controllers;

use App\Models\PartCard;
use Illuminate\Http\Request;
use App\Imports\PartCardImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class DeliveryPartcardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
    
            $query = PartCard::all();
            

            return DataTables::of($query)->toJson();
        }else{
            $partcards = PartCard::all();
            return view('delivery.master.partcard.master_partcard', compact('partcards'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("delivery.master.partcard.master_partcard_create");
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
        if ($request->hasFile('file')) {

            $data = Excel::toArray(new PartCardImport, request()->file('file'));
            $validator = Validator::make($data[0], [
                '*.color_code' => ['required'],
                '*.description' =>['required'],
                '*.remark_pertama' => ['required'],
                '*.remark_kedua' => ['required'],
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                foreach ($errors as $key => $error) {
                    $num =(int)preg_replace('/[^0-9]/', '', $error)+2;
                    $err_message = explode(".",$error)[1];
                    $errors[$key] = "Line (".$num.") $err_message";
                }

                return redirect('/delivery/master-partcard')->with('fail', "Export Failed! Because:".implode(", ",$errors));
                
            }else{

                DB::beginTransaction();

                try {
                    $proses = collect(head($data))->each(function ($row, $key) {

                            PartCard::updateOrCreate(
                                ['color_code' => $row['color_code']],
                                [
                                    'color_code' => $row['color_code'],
                                    'description' => $row['description'],
                                    'remark_1' => $row['remark_pertama'],
                                    'remark_2' => $row['remark_kedua'],
                                ]
                            );
                            
                    });

                    DB::commit();

                } catch (\Throwable $th) {

                    DB::rollback();
                    return redirect('/delivery/master-partcard')->with('fail', "Export Failed! [105]");
                }
                    
                return redirect('/delivery/master-partcard')->with('success', 'Export Succeed!');

            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PartCard  $partCard
     * @return \Illuminate\Http\Response
     */
    public function show(PartCard $partCard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PartCard  $partCard
     * @return \Illuminate\Http\Response
     */
    public function edit(PartCard $partCard, $id)
    {
        $data = PartCard::findOrFail($id);
        return view("delivery.master.partcard.master_partcard_edit", compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PartCard  $partCard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PartCard $partCard)
    {
        $validator =  Validator::make($request->all(),[
            'description' =>['required'],
            'remark_1' => ['required'],
            'remark_2' => ['required'],
            'color_code' => ['required'],
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }else{
            $selection = PartCard::find($request->id);
            try {
                $selection->update($request->all());
            } catch (\Throwable $th) {
                // throw $th;
                return redirect('/delivery/master-partcard')->with("fail","Failed Update! [105]" );
            }
            return redirect('/delivery/master-partcard')->with("success","PartCard ".$request->color_code." Updated!" );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PartCard  $partCard
     * @return \Illuminate\Http\Response
     */
    public function destroy(PartCard $partCard, $id)
    {
        try {
            $data = PartCard::findOrFail($id);
            $data->delete();

            return redirect('/delivery/master-partcard')->with("success","Part Card ".$data->color_code." Deleted!" );
        } catch (\Throwable $th) {
            // throw $th;
            return redirect('/delivery/master-partcard')->with("fail","Failed Delete! [105]" );
        }
    }

    public function insert(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'description' =>['required'],
            'remark_1' => ['required'],
            'remark_2' => ['required'],
            'color_code' => ['required'],
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }else{
            DB::beginTransaction();

            try {
                PartCard::create($request->all());
                DB::commit();

                return redirect('/delivery/master-partcard')->with('success', 'Data Partcard '.$request->customer_code.' Added!');
            } catch (\Throwable $th) {
                DB::rollback();
                return redirect('/delivery/master-partcard')->with('fail', "Add Partcard Failed! [105]");
            }
        }
    }
}
