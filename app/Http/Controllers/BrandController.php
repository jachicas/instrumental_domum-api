<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    /**
     * Create a new controller instance
     * @param Brand $brand
     * @return void
     */

    public function __construct(Brand $brand)
    {
        $this->brands = $brand;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = $this->brands->all();

        return BrandResource::collection($brands);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {
        $image = $request->image
            ->store($this->getFolder($request->image->extension()));

        $brand = $this->brands->create([
            'name' => $request->name,
            'image' => $image
        ]);

        return (new BrandResource($brand))
            ->response('Brand Created', 201);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function get($path, $resource)
    {
        $exists = Storage::exists("{$path}/{$resource}");

        if ($exists) {
            $file = Storage::get("{$path}/{$resource}");

            return response($file)
                ->header('Content-Type', $this->getMIME($path));
        } else {
            return response('', 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        return new BrandResource($brand);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        $brand->update([
            'name' => $request->name
        ]);

        return (new BrandResource($brand))
            ->response('Brand Update', 205);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        Storage::delete($brand->image);

        return response('Brand Deleted', 205);
    }

    private function getFolder($extension)
    {
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
            case 'png':
                return 'images';
        }
    }

    private function getMIME($path)
    {
        switch ($path) {
            case 'images':
                return 'image/png,image/jpeg,image/jpg';
        }
    }
}
