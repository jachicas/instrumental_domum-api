<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminSaleDetailRequest;
use App\Http\Resources\SaleDetailResource;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\SaleDetail;

class SaleDetailController extends Controller
{
    /**
     * Create a new controller instance
     * @param Offter $offter
     * @return void
     */

    public function __construct(SaleDetail $sale_detail)
    {
        $this->sale_details = $sale_detail;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $saleDetails = $this->sale_details->all();

        return SaleDetailResource::collection($saleDetails);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminSaleDetailRequest $request)
    {
        $product_price = Product::where('id', $request->product_id)->first();
        $saleDetails = $this->sale_details->create([
            'sale_id' => $request->sale_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'total' => $product_price->price * $request->quantity
        ]);

        //News variables for validations
        $quantity_product =  $saleDetails->product->quantity;

        $saleDetails->product->update([
            'quantity' => $quantity_product -= $request->quantity
        ]);

        return (new SaleDetailResource($saleDetails))
            ->response('', 201);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminSaleDetailRequest $request, SaleDetail $saleDetail)
    {
        $product_price = Product::where('id', $request->product_id)->first();
        $saleDetail->update([
            'sale_id' => $request->sale_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'total' => $product_price->price * $request->quantity
        ]);

        //News variables for validations
        $quantity_product =  $saleDetail->product->quantity;

        $saleDetail->product->update([
            'quantity' => $quantity_product -= $request->quantity
        ]);

        return (new SaleDetailResource($saleDetail))
            ->response('', 205);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleDetail $saleDetail)
    {
        $saleDetail->delete();

        return response('SaleDetail deleted', 205);
    }
}
