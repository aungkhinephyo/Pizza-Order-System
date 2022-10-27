<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{

    ## sorting products homepage
    public function sortingProducts(Request $request)
    {
        logger($request->status);
        if ($request->status == 'desc') {
            $data = Product::orderBy('created_at', 'desc')->get();
        } else {
            $data = Product::orderBy('created_at', 'asc')->get();
        }
        return $data;
    }

    ## add order product to cart
    public function addToCart(Request $request)
    {
        $data = $this->getCartProducts($request);
        Cart::create($data);
        return response()->json(['status' => 'success'], 200);
    }

    ## increase view count
    public function addViewCount(Request $request)
    {
        $product = Product::where('id', $request->product_id)->first();
        $viewcount = ['view_count' => $product->view_count + 1];
        $product->update($viewcount);
    }

    ## cart items to orderList
    public function addToOrderList(Request $request)
    {
        $totalPrice = 3;
        foreach ($request->all() as $item) {
            $data = OrderList::create([
                'user_id' => $item['user_id'],
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'total_price' => $item['total_price'],
                'order_code' => $item['order_code']
            ]);

            $totalPrice += $data->total_price;
        };

        Cart::where('user_id', Auth::user()->id)->delete();

        // logger($totalPrice);
        Order::create([
            'user_id' => Auth::user()->id,
            'order_code' => $data->order_code,
            'total_price' => $totalPrice
        ]);


        return response()->json(['status' => 'success'], 200);
    }

    ## clear cart
    public function clearCart()
    {
        Cart::where('user_id', Auth::user()->id)->delete();
        return response()->json(['status' => 'success'], 200);
    }

    ## remove cart row
    public function removeRow(Request $request)
    {
        Cart::where('id', $request->cart_id)->delete();
        return response()->json(['status' => 'success'], 200);
    }


    private function getCartProducts($request)
    {
        return [
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }
}
