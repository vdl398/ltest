<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products as ProductEntity;
use App\Models\Base\Product;

class ProductController extends Controller
{
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('product.index', [
		    'products' => Product::formatList(ProductEntity::select('*')->paginate(5))
		]);
    }
	
	
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('product.show', [
		    'product' => Product::formatItem(ProductEntity::findOrFail($id))
		]);
    }
	
}
