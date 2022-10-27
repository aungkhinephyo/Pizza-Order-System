<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RouteController extends Controller
{
    /* ============================== User =============================================== */
    // get users
    public function getUsers()
    {
        $admins =  User::whereNot('role', 'user')->get();
        $users =  User::where('role', 'user')->get();
        $data = [
            'admins' => $admins,
            'users' => $users
        ];
        return response()->json($data, 200);
    }

    // get specific user
    public function getUser($user_id)
    {
        $data =  User::where('id', $user_id)->first();
        if ($data) return response()->json($data, 200);
        return response()->json(['message' => 'No user with this ID.'], 404);
    }

    // create user
    public function createUser(Request $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ];
        $response = User::create($data);
        return response()->json($response, 200);
    }

    // update user
    public function updateUser(Request $request)
    {
        $id = $request->user_id;
        $user = User::where('id', $id)->first();
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ];
        if ($user) {
            $user->update($data);
            return response()->json($user, 200);
        }
        return response()->json(['message' => 'No user with this ID.'], 404);
    }

    // delete user
    public function deleteUser($user_id)
    {
        $user =  User::where('id', $user_id)->first();
        if ($user) {
            $user->delete();
            return response()->json(['delete-info' => $user], 200);
        }
        return response()->json(['message' => 'No user with this ID.'], 404);
    }


    /* ============================== Product =============================================== */
    // get products
    public function getProducts()
    {
        $data = Product::select('products.*', 'categories.name as category_name')
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->get();
        return response()->json($data, 200);
    }

    // get specific product
    public function getProduct($product_id)
    {
        $data =  Product::select('products.*', 'categories.name as category_name')
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->where('products.id', $product_id)
            ->first();
        if ($data) return response()->json($data, 200);
        return response()->json(['message' => 'No product with this ID.'], 404);
    }

    // create product
    public function createProduct(Request $request)
    {
        $data = [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'waiting_time' => $request->waiting_time
        ];
        $response = Product::create($data);
        return response()->json($response, 200);
    }

    // update product
    public function updateProduct(Request $request)
    {
        $id = $request->product_id;
        $product = Product::where('id', $id)->first();
        $data = [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'waiting_time' => $request->waiting_time
        ];
        if ($product) {
            $product->update($data);
            return response()->json($product, 200);
        }
        return response()->json(['message' => 'No product with this ID.'], 404);
    }

    // delete product
    public function deleteProduct($product_id)
    {
        $product =  Product::where('id', $product_id)->first();
        if ($product) {
            $product->delete();
            return response()->json(['delete-info' => $product], 200);
        }
        return response()->json(['message' => 'No product with this ID.'], 404);
    }


    /* ============================== Category =============================================== */
    // get categories
    public function getCategories()
    {
        $data = Category::get();
        return response()->json($data, 200);
    }

    // get specific user
    public function getCategory($id)
    {
        $data =  Category::where('id', $id)->first();
        if ($data) return response()->json($data, 200);
        return response()->json(['message' => 'No category with this ID.'], 404);
    }

    // create category
    public function createCategory(Request $request)
    {
        $data = [
            'name' => $request->name
        ];
        $response = Category::create($data);
        return response()->json($response, 200);
    }

    // update category
    public function updateCategory(Request $request)
    {
        $id = $request->category_id;
        $category = Category::where('id', $id)->first();
        $data = [
            'name' => $request->name
        ];
        if ($category) {
            $category->update($data);
            return response()->json($category, 200);
        }
        return response()->json(['message' => 'No category with this ID.'], 404);
    }

    // delete category
    public function deleteCategory($category_id)
    {
        $category =  Category::where('id', $category_id)->first();
        if ($category) {
            $category->delete();
            return response()->json(['delete-info' => $category], 200);
        }
        return response()->json(['message' => 'No category with this ID.'], 404);
    }


    /* ============================== Cart =============================================== */
    // get items in cart
    public function getCarts($user_id)
    {
        $data = Cart::select('carts.*', 'users.name as username', 'products.name as product_name')
            ->leftJoin('users', 'carts.user_id', 'users.id')
            ->leftJoin('products', 'carts.product_id', 'products.id')
            ->where('carts.user_id', $user_id)
            ->get();
        if ($data) return response()->json($data, 200);
        return response()->json(['message' => 'No items in cart.'], 404);
    }

    // create cart / add to cart
    public function createCart(Request $request)
    {
        $data = [
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ];
        $response = Cart::create($data);
        return response()->json($response, 200);
    }

    // update cart / change quantity
    public function updateCart(Request $request)
    {
        $id = $request->cart_id;
        $cart = Cart::where('id', $id)->first();
        $data = [
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ];
        if ($cart) {
            $cart->update($data);
            return response()->json($cart, 200);
        }
        return response()->json(['message' => 'No item with this ID.'], 404);
    }

    // delete cart
    public function deleteCart($user_id)
    {
        $cart =  Cart::where('user_id', $user_id)->get();
        if ($cart) {
            Cart::where('user_id', $user_id)->delete();
            return response()->json(['delete-info' => $cart], 200);
        }
        return response()->json(['message' => 'No item with this user ID.'], 404);
    }

    /* ============================== OrderLists =============================================== */
    // cart items to orderList, then create order
    public function cartToOrderList(Request $request)
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

        Order::create([
            'user_id' => Auth::user()->id,
            'order_code' => $data->order_code,
            'total_price' => $totalPrice
        ]);


        return response()->json(['status' => 'success'], 200);
    }

    //get order details of a user
    public function orderDetails($order_code)
    {
        $orderLists = OrderList::select('order_lists.*', 'users.name as user_name', 'products.name as product_name', 'products.image')
            ->leftJoin('users', 'order_lists.user_id', 'users.id')
            ->leftJoin('products', 'order_lists.product_id', 'products.id')
            ->where('order_code', $order_code)
            ->get();
        $overallprice = Order::where('order_code', $order_code)->get('total_price');
        return response()->json(['details' => $orderLists, 'overallprice' => $overallprice], 200);
    }


    /* ============================== Order =============================================== */
    // get all orders
    public function getOrders()
    {
        $data = Order::select('orders.*', 'users.name as user_name')
            ->leftJoin('users', 'orders.user_id', 'users.id')
            ->get();
        return response()->json($data, 200);
    }

    // get orders of a user
    public function getOrder($user_id)
    {
        $order =  Order::select('orders.*', 'users.name as user_name')
            ->leftJoin('users', 'orders.user_id', 'users.id')
            ->where('user_id', $user_id)
            ->first();
        if ($order) {
            return response()->json(['message' => $order], 200);
        }
        return response()->json(['message' => 'No order with this ID.'], 404);
    }

    // delete order
    public function deleteOrder($order_id)
    {
        $order =  Order::where('id', $order_id)->first();
        if ($order) {
            $order->delete();
            return response()->json(['delete-info' => $order], 200);
        }
        return response()->json(['message' => 'No order with this ID.'], 404);
    }

    /* ============================== Message =============================================== */
    // get messages
    public function getMessages()
    {
        $data = Contact::get();
        return response()->json($data, 200);
    }

    // create message
    public function createMessage(Request $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message
        ];
        $response = Contact::create($data);
        return response()->json($response, 200);
    }

    // delete message
    public function deleteMessage($message_id)
    {
        $message =  Contact::where('id', $message_id)->first();
        if ($message) {
            $message->delete();
            return response()->json(['delete-info' => $message], 200);
        }
        return response()->json(['message' => 'No message with this ID.'], 404);
    }
}
