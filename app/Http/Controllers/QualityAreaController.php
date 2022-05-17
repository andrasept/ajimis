<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QualityArea;
use Illuminate\Support\Facades\DB;

class QualityAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $q_areas = QualityArea::all();

        return view('quality.area.index', compact('q_areas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = auth()->user()->id;

        // DB::table('quality_areas')->insert([
        //     'name' => $request->name,
        //     'description' => $request->description,
        //     'created_by' => $user_id,
        //     'created_at' => now()
        // ]);

        $q_areas = new QualityArea;
        $q_areas->name = $request->input('name');
        $q_areas->description = $request->input('description');
        $q_areas->created_by = $user_id;
        $q_areas->created_at = now();

        if ($q_areas->save()) {
            return redirect()->route('quality.area.index')->withSuccess(__('Area created successfully.'));
        }else{
            return redirect()->route('quality.area.index')->withSuccess(__('Maaf terjadi kesalahan. Silahkan coba kembali.'));
        }

        // return redirect()->route('quality.area.index')->withSuccess(__('Area created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(QualityArea $QualityArea, $id)
    {
        $QualityArea = QualityArea::find($id);
        return view('quality.area.edit', compact('QualityArea'));

        // return view('quality.area.edit', [
        //     'QualityArea' => $QualityArea
        // ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $QualityArea->update($request->only('name', 'description', ));
        // return redirect()->route('quality.area.index')
        //     ->withSuccess(__('Area updated successfully.'));

        $user_id = auth()->user()->id;
        $QualityArea['name'] = $request->name;
        $QualityArea['description'] = $request->description;
        $QualityArea['updated_by'] = $user_id;
        $QualityArea['updated_at'] = now();
        QualityArea::find($id)->update($QualityArea);
        return redirect()->route('quality.area.index')
            ->withSuccess(__('Area updated successfully.'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(QualityArea $QualityArea, $id)
    {

        $QualityArea = QualityArea::find($id);
        $QualityArea->delete();

        return redirect()->route('quality.area.index')
            ->withSuccess(__('Area deleted successfully.'));
    }
}
