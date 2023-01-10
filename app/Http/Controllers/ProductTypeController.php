<?php

namespace App\Http\Controllers;

use App\ProductType;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productTypes = ProductType::all();
        return view('back.pages.producttypes.index', compact('productTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.pages.producttypes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:product_types',
        ]);
        $productType = new ProductType();
        $productType->name = $request->name;
        $productType->description = $request->description;
        $productType->status = $request->status;
        $productType->save();
        return redirect()->route('producttypes.index')->with('success', 'Product Type Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductType  $productType
     * @return \Illuminate\Http\Response
     */
    public function show(ProductType $productType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductType  $productType
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $productType = ProductType::find($id);
        return view('back.pages.producttypes.edit', compact('productType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductType  $productType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:product_types,name,' . $id,
        ]);
        $productType = ProductType::find($id);
        $productType->name = $request->name;
        $productType->description = $request->description;
        $productType->status = $request->status;
        $productType->save();
        return redirect()->route('producttypes.index')->with('success', 'Product Type Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductType  $productType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // $productType = ProductType::find($id);
        // $productType->delete();
        // return redirect()->route('producttypes.index')->with('success', 'Product Type Deleted Successfully');
    }
}
