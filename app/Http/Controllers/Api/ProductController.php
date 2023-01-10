<?php

namespace App\Http\Controllers\Api;

use App\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProductCreateRequest;
use App\ProductType;

class ProductController extends Controller
{
    public function getProductTypeData()
    {
        $productTypes = ProductType::whereStatus(1)->get();
        foreach ($productTypes as $key => $productType) {
            $productTypes[$key] = $productType->filterDataApi();
        }
        return response([
            'success' => true,
            'data' => $productTypes
        ]);
    }

    public function create(ProductCreateRequest $request)
    {
        $product = new Product();
        $product->product_type_id = $request->product_type_id;
        $product->name = $request->name;
        $product->description = $request->description;

        $base64EncodedImage = $request->image;
        if ($base64EncodedImage) {
            $base64DecodedImage = base64_decode($base64EncodedImage);
            $imageName = time() . '.jpg';
            $directory = 'public/images/products/' . $imageName;
            file_put_contents($directory, $base64DecodedImage);
            $product->image = $imageName;
        }
        $product->save();

        return response([
            'success' => true,
            'message' => 'Product Added Successfully',
            'data' => $product->filterDataApi()
        ]);
    }

    public function getAllProductData()
    {
        $products = Product::whereStatus(1)->get()->reverse();
        foreach ($products as $key => $product) {
            $products[$key] = $product->filterDataApi();
        }
        $products = array_values($products->toArray());
        return response([
            'success' => true,
            'data' => $products
        ]);
    }
}
