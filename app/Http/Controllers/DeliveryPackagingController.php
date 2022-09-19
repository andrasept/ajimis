<?php

namespace App\Http\Controllers;

use App\Models\Packaging;
use Illuminate\Http\Request;
use App\Imports\PackagingImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class DeliveryPackagingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
    
            $query = Packaging::all();
            

            return DataTables::of($query)->toJson();
        }else{
            $packagings = Packaging::all();
            return view('delivery.master.packaging.master_packaging', compact('packagings'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("delivery.master.packaging.master_packaging_create");
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

            $data = Excel::toArray(new PackagingImport, request()->file('file'));

            $validator = Validator::make($data[0], [
                '*.packaging_code' =>['required'],
                '*.qty_per_pallet' => ['regex:/^[0-9.-]/']
            ]);
            if ($validator->fails()) {

                $errors = $validator->errors()->all();
                foreach ($errors as $key => $error) {
                    $num =(int)preg_replace('/[^0-9]/', '', $error)+2;
                    $err_message = explode(".",$error)[1];
                    $errors[$key] = "Line (".$num.") $err_message";
                }

                return redirect('/delivery/master-packaging')->with('fail', "Export Failed! Because:".implode(", ",$errors));
                
            }else{

                DB::beginTransaction();

                try {
                    $proses = collect(head($data))->each(function ($row, $key) {

                            Packaging::updateOrCreate(
                                ['packaging_code' => $row['packaging_code']],
                                [
                                    'packaging_code' => $row['packaging_code'],
                                    'qty_per_pallet' => $row['qty_per_pallet']
                                ]
                            );
                            
                    });

                    DB::commit();

                } catch (\Throwable $th) {

                    DB::rollback();
                    return redirect('/delivery/master-packaging')->with('fail', "Export Failed! [105]");
                }
                    
                return redirect('/delivery/master-packaging')->with('success', 'Export Succeed!');

            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Packaging  $packaging
     * @return \Illuminate\Http\Response
     */
    public function show(Packaging $packaging)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Packaging  $packaging
     * @return \Illuminate\Http\Response
     */
    public function edit(Packaging $packaging, $id)
    {
        $data = Packaging::findOrFail($id);
        return view("delivery.master.packaging.master_packaging_edit", compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Packaging  $packaging
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Packaging $packaging)
    {
        $validator =  Validator::make($request->all(),[
            'packaging_code' =>['required'],
            'qty_per_pallet' => ['regex:/^[0-9.-]/']
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }else{
            $selection = Packaging::find($request->id);
            try {
                $selection->update($request->all());
            } catch (\Throwable $th) {
                // throw $th;
                return redirect('/delivery/master-packaging')->with("fail","Failed Update! [105]" );
            }
            return redirect('/delivery/master-packaging')->with("success","Packaging ".$request->packaging_code." Updated!" );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Packaging  $packaging
     * @return \Illuminate\Http\Response
     */
    public function destroy(Packaging $packaging, $id)
    {
        try {
            $data = Packaging::findOrFail($id);
            $data->delete();

            return redirect('/delivery/master-packaging')->with("success","Packaging ".$data->packaging_code." Deleted!" );
        } catch (\Throwable $th) {
            // throw $th;
            return redirect('/delivery/master-packaging')->with("fail","Failed Delete! [105]" );
        }
    }

    public function insert(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'packaging_code' =>['required'],
            'qty_per_pallet' => ['regex:/^[0-9.-]/']
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }else{
            DB::beginTransaction();

            try {
                Packaging::create($request->all());
                DB::commit();

                return redirect('/delivery/master-packaging')->with('success', 'Data Packaging '.$request->packaging_code.' Added!');
            } catch (\Throwable $th) {
                DB::rollback();
                return redirect('/delivery/master-packaging')->with('fail', "Add Packaging Failed! [105]");
            }
        }
    }
}
