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
        $offter = $this->offters->create($request->all());

        //event(new OffterRegistered($offter));

        return (new OffterResource($offter))
            ->response('', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Offter $offter)
    {
        return new OffterResource($offter);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OffterRequest $request, Offter $offter)
    {
        $offter->update($request->all());

        return (new OffterResource($offter))
            ->response('', 205);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offter $offter)
    {
        $offter->delete();

        return response('Offter deleted', 205);
    }
}
