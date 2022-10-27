<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderList;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    ## go to order list page
    public function listPage()
    {
        $orders = Order::select('orders.*', 'users.name as user_name')
            ->leftJoin('users', 'orders.user_id', 'users.id')
            ->orderBy('updated_at', 'asc')
            ->paginate(4);
        $orders->appends(request()->all());
        return view('admin.order.list', compact('orders'));
    }

    ## sorting orders
    public function sortingOrders(Request $request)
    {
        // logger($request->status);
        $data = Order::select('orders.*', 'users.name as user_name')
            ->leftJoin('users', 'orders.user_id', 'users.id')
            ->orderBy('updated_at', 'asc');

        if ($request->status == 'all') {
            $data = $data->get();
        } else {
            $data = $data->where('status', $request->status)->get();
        }
        return $data;
    }

    ##change status
    public function changeStatus(Request $request)
    {
        Order::where('id', $request->id)->update(['status' => $request->status]);
        return response()->json(['status' => 'success'], 200);
    }

    ##go to order details page
    public function orderDetails($orderCode)
    {
        $orderLists = OrderList::select('order_lists.*', 'users.name as user_name', 'products.name as product_name', 'products.image')
            ->leftJoin('users', 'order_lists.user_id', 'users.id')
            ->leftJoin('products', 'order_lists.product_id', 'products.id')
            ->where('order_code', $orderCode)
            ->orderBy('updated_at', 'asc')
            ->get();
        $overallprice = Order::where('order_code', $orderCode)->pluck('total_price');
        return view('admin.order.details', compact('orderLists', 'overallprice'));
    }

    // delete order
    public function delete(Request $request)
    {
        Order::where('id', $request->id)->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
