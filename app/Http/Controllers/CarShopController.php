<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddItemRequest;
use App\Http\Requests\PayCarShopRequest;
use App\Http\Resources\CarShopItemResource;
use App\Http\Resources\CarShopResource;
use App\Http\Resources\SaleResource;
use App\Models\Offter;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Exception;
use Stripe\Stripe;
use Stripe\StripeClient;

use function PHPUnit\Framework\isEmpty;

class CarShopController extends Controller
{
    /**
     * Create a new controller instance
     * @param SaleDetail $offter
     * @return void
     */

    public function showCarShop()
    {
        $sale = auth()->user()->sales->where('status', true);

        return CarShopResource::collection($sale);
    }

    public function addItem(AddItemRequest $request)
    {
        $sale_active = auth()->user()->sales->where('status', true)->values();
        if ($sale_active->isEmpty()) {
            $new_sale = Sale::create([
                'user_id' => auth()->user()->id,
                'status' => true
            ]);
            $product = Product::where('id', $request->product_id)->first();
            $product_price = Offter::where([
                ['product_id', $product->id],
                ['start', '<=', now()],
                ['finish', '>=', now()]
            ])->first();
            if ($product_price) {
                $discount = $product->price * ($product_price->discount / 100);
                $totalSaleDetail = ($product->price - $discount) * $request->quantity;
                $with_discount = true;
            } else {
                $totalSaleDetail = $product->price * $request->quantity;
                $with_discount = false;
            }
            $saleDetails = SaleDetail::create([
                'sale_id' => $new_sale->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'total' => $totalSaleDetail,
                'with_discount' => $with_discount
            ]);

            return (new CarShopItemResource($saleDetails))
                ->response('', 200);
        } else {
            $product = Product::where('id', $request->product_id)->first();
            $product_price = Offter::where([
                ['product_id', $product->id],
                ['start', '<=', now()],
                ['finish', '>=', now()]
            ])->first();
            if ($product_price) {
                $discount = $product->price * ($product_price->discount / 100);
                $totalSaleDetail = ($product->price - $discount) * $request->quantity;
                $with_discount = true;
            } else {
                $totalSaleDetail = $product->price * $request->quantity;
                $with_discount = false;
            }

            $saleDetails = SaleDetail::create([
                'sale_id' => $sale_active[0]->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'total' => $totalSaleDetail,
                'with_discount' => $with_discount
            ]);

            return (new CarShopItemResource($saleDetails))
                ->response('', 200);
        }
    }

    public function removeItem(SaleDetail $saleDetail)
    {
        $sale_active = auth()->user()->sales->where('status', true);
        if (!$sale_active->isEmpty()) {
            if ($saleDetail->sale->user_id == auth()->id()) {
                $saleDetail->delete();

                return response('Item removed', 200);
            } else {
                return response('UNAUTHORIZED', 422);
            }
        } else {
            return response('Your car shop is empty', 404);
        }
    }

    public function payCarShop(PayCarShopRequest $request)
    {
        $user_sale = auth()->user()->sales->where('status', true)->first();
        if ($user_sale->saleDetails->isNotEmpty()) {
            $total_sale = $user_sale->saleDetails->sum->total;

            Stripe::setApiKey('sk_test_51Hz8buJdRKL0oZle7N2lOUBKag79TRQToSNAGXg0FMOlP7a9xyLjlPRqX2PuCo0wH603IZPcjalhEIbXk6gBkVEo0083TgCv9C');

            $stripe = new StripeClient('sk_test_51Hz8buJdRKL0oZle7N2lOUBKag79TRQToSNAGXg0FMOlP7a9xyLjlPRqX2PuCo0wH603IZPcjalhEIbXk6gBkVEo0083TgCv9C');

            try {
                $stripe->tokens->create([
                    'card' => $request->only('card')
                ]);
            } catch (Exception $e) {
                return response('Error: ' . $e->getMessage(), 400);
            }

            try {
                $stripe->charges->create([
                    'amount' => $total_sale * 100,
                    'currency' => "usd",
                    'source' => "tok_mastercard",
                    'description' => "Instrumental domum"
                ]);
            } catch (\Exception $e) {
                return response('ERROR ' . $e, 404);
            }

            $user_sale->update([
                'payment_method' => 'card',
                'total' => $total_sale,
                'status' => false
            ]);

            return (new SaleResource($user_sale))
                ->response('', 205);
        } else {
            return response('Sale not active', 422);
        }
    }
}
