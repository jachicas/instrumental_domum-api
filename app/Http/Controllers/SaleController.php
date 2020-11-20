<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleRequest;
use App\Http\Resources\SaleResource;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
     /**
     * Create a new controller instance
     * @param Sale $sale
     * @return void
     */

    public function __construct(Sale $sale)
    {
        $this->sales = $sale;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = $this->sales->all();

        return SaleResource::collection($sales);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleRequest $request)
    {
        $sales = $this->sales->create($request->all());

        return (new SaleResource($sales))
            ->response('', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        return new SaleResource($sale);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaleRequest $request, Sale $sale)
    {
        $sale->update($request->all());

        return (new SaleResource($sale))
            ->response('', 205);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        $sale->delete();

        return response('Sale deleted', 205);
    }
}
