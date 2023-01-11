<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductType;
use Illuminate\Http\Request;

class ProductController extends Controller
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
        $product = Product::all();
        $productTypes = ProductType::whereStatus('1')->get();
        return view('back.pages.products.index', compact('product', 'productTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productType = ProductType::whereStatus('1')->get();
        return view('back.pages.products.create', compact('productType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_type_id' => ['required'],
            'image' => ['required'],
            'name' => ['required']
        ]);
        $product = new Product();
        if ($request->hasFile('image')) {
            $photo = time() . '.' . $request->file('image')->getClientOriginalExtension();
            move_uploaded_file($request->image, 'public/images/products/' . $photo);
            $product->image = $photo;

            $product->product_type_id = $request->get('product_type_id');
            $product->name = $request->get('name');
            $product->description = $request->get('description');
            $product->status = $request->get('status');
        } else {
            $product->product_type_id = $request->get('product_type_id');
            $product->name = $request->get('name');
            $product->description = $request->get('description');
            $product->status = $request->get('status');
        }
        $product->save();
        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $productType = ProductType::whereStatus('1')->get();
        return view('back.pages.products.edit', compact('product', 'productType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'product_type_id' => ['required'],
            'name' => ['required']
        ]);
       $product = Product::find($id);
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            if ($product->image != "") {
                if (file_exists('public/images/products/' . $product->image)) {
                    unlink('public/image/products/' . $product->image);
                }
            }
            move_uploaded_file($request->image, 'public/image/products/' . $imageName);

            $product->image = $imageName;
            $product->product_type_id = $request->get('product_type_id');
            $product->name = $request->get('name');
            $product->description = $request->get('description');
            $product->status = $request->get('status');
        } else {
            $product->product_type_id = $request->get('product_type_id');
            $product->name = $request->get('name');
            $product->description = $request->get('description');
            $product->status = $request->get('status');
        }
        $product->save();

        return redirect()->route('products.index')
            ->with('success', 'Product  updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }
}
