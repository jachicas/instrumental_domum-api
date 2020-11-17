<?php

namespace App\Http\Controllers;

use App\Events\OffterRegistered;
use App\Http\Requests\OffterRequest;
use App\Http\Resources\OffterResource;
use App\Models\Offter;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OffterController extends Controller
{
    /**
     * Create a new controller instance
     * @param Offter $offter
     * @return void
     */

    public function __construct(Offter $offter)
    {
        $this->offters = $offter;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offters = $this->offters->all();

        return OffterResource::collection($offters);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OffterRequest $request)
    {
        $offter = $this->offters->create([
            'product_id' => $request->product_id,
            'discount' => $request->discount,
            'status' => $request->status,
            'start' => Carbon::now(),
            'finish' => $request->finish
        ]);

        event(new OffterRegistered($offter));

        return (new OffterResource($offter))
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
}
