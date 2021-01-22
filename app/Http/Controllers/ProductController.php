<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddProductRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\RemoveProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductBinnacle;

class ProductController extends Controller
{
    /**
     * Create a new controller instance
     * @param Product $product
     * @return void
     */

    public function __construct(Product $product)
    {
        $this->products = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->products->all();

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product = $this->products->create($request->all());

        ProductBinnacle::create([
            'product_id' => $product->id,
            'employee_id' => auth()->id(),
            'description' => $request->name . " product created",
            'action' => "create"
        ]);

        return (new ProductResource($product))
            ->response('', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->all());

        ProductBinnacle::create([
            'product_id' => $product->id,
            'employee_id' => auth()->id(),
            'description' => "Product updated",
            'action' => "update"
        ]);

        return (new ProductResource($product))
            ->response('', 205);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response('Product deleted', 205);
    }

    public function addQuantityProduct(AddProductRequest $request, Product $product)
    {
        $product->update([
            'quantity' => $product->quantity += $request->quantity
        ]);

        ProductBinnacle::create([
            'product_id' => $product->id,
            'employee_id' => auth()->id(),
            'description' => $request->quantity . " products added",
            'action' => "add"
        ]);

        return (new ProductResource($product))
            ->response('', 201);
    }

    public function removeQuantityProduct(RemoveProductRequest $request, Product $product)
    {
        if ($product->quantity == 0) {
            return response('This product is out of stock!', 422);
        } elseif ($request->quantity > $product->quantity) {
            return response('The quantity must be less than or equal to the quantity of the product', 422);
        }
        if (!($product->status)) {
            return response('This product is not avaible', 422);
        }

        $product->update([
            'quantity' => $product->quantity -= $request->quantity
        ]);

        ProductBinnacle::create([
            'product_id' => $product->id,
            'employee_id' => auth()->id(),
            'description' => $request->quantity . " products removed",
            'action' => "remove"
        ]);

        return (new ProductResource($product))
            ->response('', 201);
    }

    public function activeProducts()
    {
        $products = $this->products->where('status', true)->get()->values();

        return ProductResource::collection($products);
    }
}
