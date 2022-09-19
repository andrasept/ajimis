<?php

namespace App\Http\Controllers;

use App\Models\Line;
use App\Imports\LineImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class DeliveryLineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
    
            $query = Line::all();
            

            return DataTables::of($query)->toJson();
        }else{
            $lines = Line::all();
            return view('delivery.master.line.master_line', compact('lines'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("delivery.master.line.master_line_create");
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

            $data = Excel::toArray(new LineImport, request()->file('file'));
            $validator = Validator::make($data[0], [
                '*.line_code' =>['required'],
                '*.line_name' => ['required'],
                '*.line_category' => ['required'],
                // 'tonase' => ['required']
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                foreach ($errors as $key => $error) {
                    $num =(int)preg_replace('/[^0-9]/', '', $error)+2;
                    $err_message = explode(".",$error)[1];
                    $errors[$key] = "Line (".$num.") $err_message";
                }

                return redirect('/delivery/master-line')->with('fail', "Export Failed! Because:".implode(", ",$errors));
                
            }else{

                DB::beginTransaction();

                try {
                    $proses = collect(head($data))->each(function ($row, $key) {

                            Line::updateOrCreate(
                                ['line_code' => $row['line_code']],
                                [
                                    'line_code' => $row['line_code'],
                                    'line_name' => $row['line_name'],
                                    'line_category' => $row['line_category'],
                                    'tonase' => $row['tonase']
                                ]
                            );
                            
                    });

                    DB::commit();

                } catch (\Throwable $th) {

                    DB::rollback();
                    return redirect('/delivery/master-line')->with('fail', "Export Failed! [105]");
                }
                    
                return redirect('/delivery/master-line')->with('success', 'Export Succeed!');

            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Line  $line
     * @return \Illuminate\Http\Response
     */
    public function show(Line $line)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Line  $line
     * @return \Illuminate\Http\Response
     */
    public function edit(Line $line, $id)
    {
        $data = Line::findOrFail($id);
        return view("delivery.master.line.master_line_edit", compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Line  $line
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Line $line)
    {
        $validator =  Validator::make($request->all(),[
            'line_code' =>['required'],
            'line_name' => ['required'],
            'line_category' => ['required'],
            // 'tonase' => ['required']
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }else{
            $selection = Line::find($request->id);
            try {
                $selection->update($request->all());
            } catch (\Throwable $th) {
                // throw $th;
                return redirect('/delivery/master-line')->with("fail","Failed Update! [105]" );
            }
            return redirect('/delivery/master-line')->with("success","Line ".$request->line_code." Updated!" );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Line  $line
     * @return \Illuminate\Http\Response
     */
    public function destroy(Line $line, $id)
    {
        try {
            $data = Line::findOrFail($id);
            $data->delete();

            return redirect('/delivery/master-line')->with("success","Line ".$data->line_code." Deleted!" );
        } catch (\Throwable $th) {
            // throw $th;
            return redirect('/delivery/master-line')->with("fail","Failed Delete! [105]" );
        }
    }

    public function insert(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'line_code' =>['required'],
            'line_name' => ['required'],
            'line_category' => ['required'],
            'tonase' => ['required']
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }else{
            DB::beginTransaction();

            try {
                Line::create($request->all());
                DB::commit();

                return redirect('/delivery/master-line')->with('success', 'Data Line '.$request->line_code.' Added!');
            } catch (\Throwable $th) {
                DB::rollback();
                return redirect('/delivery/master-line')->with('fail', "Add line Failed! [105]");
            }
        }
    }
}
