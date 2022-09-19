<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QualityNgCategory;
use Illuminate\Support\Facades\DB;

class QualityNgCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $q_ngcategories = QualityNgCategory::orderBy('id','DESC')->get();

        return view('quality.ngcategory.index', compact('q_ngcategories'));
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
        $user_id = auth()->user()->id;

        $q_ngcategories = new QualityNgCategory;
        $q_ngcategories->name = $request->input('name');
        $q_ngcategories->description = $request->input('description');
        $q_ngcategories->created_by = $user_id;
        $q_ngcategories->created_at = now();

        if ($q_ngcategories->save()) {
            return redirect()->route('quality.ngcategory.index')->withSuccess(__('NG Category created successfully.'));
        }else{
            return redirect()->route('quality.ngcategory.index')->withSuccess(__('Maaf terjadi kesalahan. Silahkan coba kembali.'));
        }
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
    public function edit(QualityNgCategory $QualityNgCategory, $id)
    {
        $QualityNgCategory = QualityNgCategory::find($id);
        return view('quality.ngcategory.edit', compact('QualityNgCategory'));
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
        $user_id = auth()->user()->id;
        $QualityNgCategory['name'] = $request->name;
        $QualityNgCategory['description'] = $request->description;
        $QualityNgCategory['updated_by'] = $user_id;
        $QualityNgCategory['updated_at'] = now();
        QualityNgCategory::find($id)->update($QualityNgCategory);
        return redirect()->route('quality.ngcategory.index')
            ->withSuccess(__('NG Category updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(QualityNgCategory $QualityNgCategory, $id)
    {
        $QualityNgCategory = QualityNgCategory::find($id);
        $QualityNgCategory->delete();

        return redirect()->route('quality.ngcategory.index')
            ->withSuccess(__('NG Category deleted successfully.'));
    }
}
