<?php

namespace App\Http\Controllers;

use App\Models\Line;
use App\Models\Part;
use App\Models\Customer;
use App\Models\PartCard;
use App\Models\Packaging;
use App\Exports\PartsExport;
use App\Imports\PartsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class DeliveryPartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
    
            $query = DB::table('delivery_parts')
            ->join('delivery_customers', 'delivery_parts.customer_id', '=', 'delivery_customers.customer_code')
            ->leftjoin('delivery_part_cards', 'delivery_parts.color_id', '=', 'delivery_part_cards.color_code')
            ->leftjoin('delivery_lines', 'delivery_parts.line_id', '=', 'delivery_lines.line_code')
            ->leftjoin('delivery_packagings', 'delivery_parts.packaging_id', '=', 'delivery_packagings.packaging_code')
            ;

            if ($request->customer != 'all') {
                $query->where('delivery_parts.customer_id', $request->customer);
            }
            if ($request->partcard != 'all') {
                $query->where('delivery_parts.color_id', $request->partcard);
            }
            if ($request->line != 'all') {
                $query->where('delivery_parts.line_id', $request->line);
            }
            if ($request->packaging_code != 'all') {
                $query->where('delivery_parts.packaging_id', $request->packaging_code);
            }
            if ($request->category != 'all') {
                $query->where('delivery_parts.category', $request->category);
            }
            $query= $query->select('delivery_parts.id', 'delivery_parts.sku', 'delivery_parts.part_name', 'delivery_parts.part_no_customer', 'delivery_parts.part_no_aji','delivery_parts.model','delivery_customers.customer_name',
                'delivery_parts.category','delivery_parts.cycle_time','delivery_parts.addresing','delivery_part_cards.description','delivery_lines.line_name','delivery_packagings.qty_per_pallet','delivery_packagings.packaging_code'
                )->orderBy('delivery_parts.sku','asc')->get();
            return DataTables::of($query)->toJson();
        }else{
            $customers = Customer::orderBy('customer_name', 'asc')->get();
            $lines = Line::all();
            $packagings = Packaging::all();
            $partcards = PartCard::all();
            return view('delivery.master.part.master_part', compact('customers','lines','packagings','partcards'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        $customers = Customer::orderBy('customer_name', 'asc')->get();
        $lines = Line::all();
        $packagings = Packaging::all();
        $partcards = PartCard::all();
        return view("delivery.master.part.master_part_create", compact('customers','lines','packagings','partcards'));
        
    }

    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sku' => ['required', 'unique:delivery_parts'],
            'part_no_customer' =>  ['required','unique:delivery_parts'],
            'part_no_aji' =>  ['required','unique:delivery_parts'],
            'part_name' =>  ['required','unique:delivery_parts'],
            'model' =>  ['required','unique:delivery_parts'],
            'customer_id' =>  ['required'],
            'color_id' => ['required','regex:/[^.-]/'],
            'line_id' => ['required','regex:/[^.-]/'],
            'packaging_id' =>  ['required','regex:/[^.-]/'],
            'cycle_time' =>  ['regex:/^[0-9]/'],
            'category' =>  ['in:FG,SFG,fg,sfg'],
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }else{
            DB::beginTransaction();

            try {
                Part::create($request->all());
                DB::commit();
                $message = "SKU ".$request->sku." Part Added!, added By: ".auth()->user()->name;
                $this->sendTelegram('-690929411',$message );
                return redirect('/delivery/master-part')->with('success', 'Data SKU '.$request->sku.' Part Added!');
            } catch (\Throwable $th) {
                DB::rollback();
                return redirect('/delivery/master-part')->with('fail', "Add Part Failed! [105]");
            }
        }
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
                    '*.cycle_time' =>  ['regex:/^[0-9]/'],
                    '*.category' =>  ['in:FG,SFG,fg,sfg'],
                    // '*.color_id' => ['required'],
                    // '*.line_id' => ['required'],
                    // '*.packaging_id' =>  ['required'],
                ]);
                if ($validator->fails()) {

                    $errors = $validator->errors()->all();
                    foreach ($errors as $key => $error) {
                        $num =(int)preg_replace('/[^0-9]/', '', $error)+2;
                        $err_message = explode(".",$error)[1];
                        $errors[$key] = "Line (".$num.") $err_message";
                    }

                    return redirect('/delivery/master-part')->with('fail', "Export Failed! Because:".implode(", ",$errors));
                    
                }else{

                    DB::beginTransaction();

                    try {
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

                        DB::commit();

                    } catch (\Throwable $th) {

                        DB::rollback();
                        return redirect('/delivery/master-part')->with('fail', "Export Failed! [105]");
                    }
                        
                    return redirect('/delivery/master-part')->with('success', 'Export Succeed!');

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
        $customers = Customer::orderBy('customer_name', 'asc')->get();
        $lines = Line::all();
        $packagings = Packaging::all();
        $partcards = PartCard::all();
        return view("delivery.master.part.master_part_edit", compact('data','customers','lines','packagings','partcards'));
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
            'color_id' => ['required','regex:/[^.-]/'],
            'line_id' => ['required','regex:/[^.-]/'],
            'packaging_id' =>  ['required','regex:/[^.-]/'],
        ]);

        if ($validator->fails()) {
            
            return redirect()->back()->with("fail","".implode(" ",$validator->errors()->all()) );
        } else {
            $selection = Part::find($request->id);
            try {
                $selection->update($request->all());
            } catch (\Throwable $th) {
                // throw $th;
                return redirect('/delivery/master-part')->with("fail","Failed Update! [105]" );
            }
            $json_part = json_encode($selection);
            $message = "SKU ".$request->sku." Part Updated!, updated By: ".$request->updated_by;
            $this->sendTelegram('-690929411',$message );
            return redirect('/delivery/master-part')->with("success","SKU ".$request->sku." Updated!" );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function destroy(Part $part, $id)
    {
        try {
            $data = Part::findOrFail($id);
            $data->delete();
            $message = "SKU ".$data->sku." Part Deleted!, deleted By: ".auth()->user()->name;
            $this->sendTelegram('-690929411',$message );
            return redirect('/delivery/master-part')->with("success","SKU ".$data->sku." Deleted!" );
        } catch (\Throwable $th) {
            // throw $th;
            return redirect('/delivery/master-part')->with("fail","Failed Delete! [105]" );
        }
    }

    public function export() 
    {
        $arrays =  Part::all();
        return Excel::download(new PartsExport($arrays), 'delivery_parts.xlsx');
    }

    public function sendTelegram($chat_id, $text)
    {
        $token ='1488492213:AAFkw2dzki-No0W5tuu8JjAwm0mvg__98BU';
        $url = 'https://api.telegram.org/bot'.$token.'/sendMessage?chat_id='.$chat_id.'&text='.$text;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec ($ch);
        $err = curl_error($ch); 
        curl_close ($ch);
    }
}
