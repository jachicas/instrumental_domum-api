<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminSaleDetailRequest;
use App\Http\Resources\SaleDetailResource;
use App\Models\Offter;
use App\Models\Product;
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
        $product = Product::where('id', $request->product_id)->first();
        $product_price = Offter::where([
            ['status', true],
            ['product_id', $request->product_id]
        ])->get();
        if (!$product_price->isEmpty()) {
            $discount = $product->price * ($product_price[0]->discount / 100);
            $totalSaleDetail = ($product->price - $discount) * $request->quantity;
            $with_discount = true;
        } else {
            $totalSaleDetail = $product->price * $request->quantity;
            $with_discount = false;
        }
        $saleDetails = $this->sale_details->create([
            'sale_id' => $request->sale_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'total' => $totalSaleDetail,
            'with_discount' => $with_discount
        ]);

        //News variables for validations
        $quantity_product =  $saleDetails->product->quantity;

        $saleDetails->product->update([
            'quantity' => $quantity_product -= $request->quantity
        ]);

        $saleDetails->sale->update([
            'total' => $totalSaleDetail += $saleDetails->sale->total
        ]);

        return (new SaleDetailResource($saleDetails))
            ->response('', 201);
    }
}
