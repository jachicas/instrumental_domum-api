<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductTypeRequest;
use App\Http\Resources\ProductTypeResource;
use App\Models\ProductType;

class ProductTypeController extends Controller
{
    /**
     * Create a new controller instance
     * @param ProductType $product_type
     * @return void
     */

    public function __construct(ProductType $product_type)
    {
        $this->product_types = $product_type;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product_types = $this->product_types->all();

        return ProductTypeResource::collection($product_types);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductTypeRequest $request)
    {
        $product_type = $this->product_types->create($request->all());

        return (new ProductTypeResource($product_type))
            ->response('Product type created', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ProductType $productType)
    {
        return new ProductTypeResource($productType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductTypeRequest $request, ProductType $productType)
    {
        $productType->update($request->all());

        return (new ProductTypeResource($productType))
            ->response('', 205);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductType $productType)
    {
        $productType->delete();

        return response()->json([
            "message" => "Product Type deleted"
        ], 205);
    }
}
