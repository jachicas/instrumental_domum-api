<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Create a new controller instance
     * @param Image $image
     * @return void
     */

    public function __construct(Image $image)
    {
        $this->images = $image;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = $this->images->all();

        return ImageResource::collection($images);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageRequest $request)
    {
        $image = $request->image
            ->store($this->getFolder($request->image->extension()));

        $data = $this->images->create([
            'name' => $request->name,
            'image' => $image
        ]);

        return (new ImageResource($data))
            ->response('', 201);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        $request->validate([
            "name" => ['required', 'string']
        ]);

        $image->update([
            'name' => $request->name
        ]);

        return (new ImageResource($image))
            ->response('', 205);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        $image->delete();

        Storage::delete($image->image);

        return response()->json([
            "message" => "Image deleted"
        ], 205);
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
