<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Imports\PartsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class DeliveryMasterPartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
    
            $query = DB::table('parts')
            ->join('delivery_customers', 'parts.customer_id', '=', 'delivery_customers.customer_code')
            ->join('delivery_part_cards', 'parts.color_id', '=', 'delivery_part_cards.color_code')
            ->join('delivery_lines', 'parts.line_id', '=', 'delivery_lines.line_code')
            ->join('delivery_packagings', 'parts.packaging_id', '=', 'delivery_packagings.packaging_code')
            ->select('*')
            ->get();
            return DataTables::of($query)->toJson();
        }else{
            return view('delivery.master.master_part');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = Excel::toArray(new PartsImport, request()->file('file'));
        $validator = Validator::make($data[0], [
            '*.sku' => ['required'],
            '*.part_no_customer' =>  ['required'],
            '*.part_no_aji' =>  ['required'],
            '*.part_name' =>  ['required'],
            '*.model' =>  ['required'],
            '*.customer_id' =>  ['required'],
            '*.color_id' => ['required'],
            '*.line_id' => ['required'],
            '*.packaging_id' =>  ['required'],
        ]);
    if ($validator->fails()) {

        $errors = $validator->errors()->all();
        foreach ($errors as $key => $error) {
            $num =(int)preg_replace('/[^0-9]/', '', $error)+1;
            $err_message = explode(".",$error)[1];
            $errors[$key] = "Line (".$num.") $err_message";
        }

        return redirect('/delivery-master-part')->with('fail', "Export Failed! Because:".implode(", ",$errors));
        
    }else{
        $proses = collect(head($data))->each(function ($row, $key) {
            Part::updateOrCreate(
                    ['sku' => $row['sku']],
                    [
                        'sku' => $row['sku'],
                        'part_no_customer' => $row['part_no_customer'],
                        'part_no_aji' => $row['part_no_aji'],
                        'part_name' => $row['part_name'],
                        'model' => $row['model'],
                        'customer_id' => $row['customer_id'],
                        'category' => $row['category'],
                        'cycle_time' => $row['cycle_time'],
                        'addresing' => $row['addresing'],
                        'color_id' => $row['color_id'],
                        'line_id' => $row['line_id'],
                        'packaging_id' => $row['packaging_id'],
                    ]
                );
            
        });
        return redirect('/delivery-master-part')->with('success', 'Export Succeed!');

        }
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function show(Part $part)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function edit(Part $part)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Part $part)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function destroy(Part $part)
    {
        //
    }
}
