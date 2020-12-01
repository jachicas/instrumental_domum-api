<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductBinnacleResource;
use App\Models\Product;
use App\Models\ProductBinnacle;
use Illuminate\Http\Request;

class ProductBinnacleController extends Controller
{
    /**
     * Create a new controller instance
     * @param ProductBinnacle $offter
     * @return void
     */

    public function __construct(ProductBinnacle $productBinnacle)
    {
        $this->productBinnacles = $productBinnacle;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product_binnacle = $this->productBinnacles->all();

        return ProductBinnacleResource::collection($product_binnacle);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ProductBinnacle $product_binnacle)
    {
        return new ProductBinnacleResource($product_binnacle);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function withAction(Request $request, Product $product)
    {
        $request->validate([
            'action' => ['required', 'in:create,update,add,remove']
        ]);

        $result = $this->productBinnacles->where([
            ['product_id', $product->id],
            ['action', $request->action]
        ])->get();

        return ProductBinnacleResource::collection($result);
    }
}
