<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Imports\PartsImport;
use App\Models\DeliveryLine;
use Illuminate\Http\Request;
use App\Models\DeliveryCustomer;
use App\Models\DeliveryPartCard;
use App\Models\DeliveryPackaging;
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
            ->select('parts.id', 'parts.sku', 'parts.part_name', 'parts.part_no_customer', 'parts.part_no_aji','parts.model','delivery_customers.customer_name',
                    'parts.category','parts.cycle_time','parts.addresing','delivery_part_cards.description','delivery_lines.line_name','delivery_packagings.qty_per_pallet'
                    )
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
        // untuk import excel 
            if ($request->hasFile('file')) {
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

        // untuk request biasa 
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
    public function edit(Part $part, $id)
    {
        $data = Part::findOrFail($id);
        $customers = DeliveryCustomer::all();
        $lines = DeliveryLine::all();
        $packagings = DeliveryPackaging::all();
        $partcards = DeliveryPartCard::all();
        return view("delivery.master.master_part_edit", compact('data','customers','lines','packagings','partcards'));
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
        
        $validator = Validator::make($request->all(), [
            'sku' => ['required'],
            'part_no_customer' =>  ['required'],
            'part_no_aji' =>  ['required'],
            'part_name' =>  ['required'],
            'model' =>  ['required'],
            'customer_id' =>  ['required'],
            'color_id' => ['required'],
            'line_id' => ['required'],
            'packaging_id' =>  ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with("error",$validator->errors() );
        } else {
            $selection = Part::find($request->id);
            $selection->update($request->all());
            return redirect('/delivery-master-part')->with("success","SKU ".$request->sku." Updated!" );
        }
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
