<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Models\Products;
use App\Models\Categories;

class ProductController extends Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.product.index', [
		    'products' => Products::select('*')->paginate(5)
		]);
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
		$data = $request->validate(Products::getValidateParams());
		$product = new Products;
		$product->fill($data);
        $product->save();
		if (!(int)$product->id) {
			return back()->withErrors(['add error']);
		}
        return redirect('/admin/product/'.$product->id.'/edit')->withSuccess('Save success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.product.show', [
		    'product' => Products::find($id),
			'categories' => Categories::select('id', 'name')->get()
		]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.product.edit', [
		    'product' => Products::find($id),
			'categories' => Categories::select('id', 'name')->get()
		]);
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
		$data = $request->validate(Products::getValidateParams());
		$product = Products::findOrFail($id);
		$product->fill($data);
        $product->save();
        return redirect('/admin/product/'.$id.'/edit')->withSuccess('Save success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		try {
		    $product = Products::findOrFail($id);
            $product->delete();
		} catch(\Throwable $e) {
	        return back()->withErrors(['Ошибка удаления']);
		}
		return redirect('/admin/product');
    }
}