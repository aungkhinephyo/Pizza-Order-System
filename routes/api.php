<?php

use App\Http\Controllers\API\RouteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Routing\RouteCompiler;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// user Read 2, Create, Update, Delete
Route::get('users', [RouteController::class, 'getUsers']);
Route::get('users/{user_id}', [RouteController::class, 'getUser']); // user_id
Route::post('users/create', [RouteController::class, 'createUser']); // name,email,phone,gender,address,password
Route::post('users/update', [RouteController::class, 'updateUser']); // user_id,name,email,phone,gender,address,password
Route::get('users/delete/{user_id}', [RouteController::class, 'deleteUser']); // user_id

//products Read 2, Create, Update, Delete
Route::get('products', [RouteController::class, 'getProducts']);
Route::get('products/{product_id}', [RouteController::class, 'getProduct']); //product_id
Route::post('products/create', [RouteController::class, 'createProduct']); // category_id, name, description, price, waiting_time
Route::post('products/update', [RouteController::class, 'updateProduct']);  // product_id, category_id, name, description, price, waiting_time
Route::get('products/delete/{product_id}', [RouteController::class, 'deleteProduct']); //product_id

//category Read 2, Create, Update, Delete
Route::get('categories', [RouteController::class, 'getCategories']);
Route::post('categories/create', [RouteController::class, 'createCategory']); // name
Route::post('categories/update', [RouteController::class, 'updateCategory']); // category_id, name
Route::get('categories/delete/{category_id}', [RouteController::class, 'deleteCategory']);

//cart
Route::get('carts/{user_id}', [RouteController::class, 'getCarts']); // user_id
Route::post('carts/create', [RouteController::class, 'createCart']); // user_id, product_id, quantity
Route::post('carts/update', [RouteController::class, 'updateCart']); // cart_id, user_id, product_id, quantity
Route::get('carts/delete/{user_id}', [RouteController::class, 'deleteCart']); // user_id

//orderList
// get orders details of a user for one order_code
Route::get('orderLists/{order_code}', [RouteController::class, 'orderDetails']); // order_code

// cart to orderlist and then create order  // eg.[{item1 details},{item2 details}] => order_code must be the same
Route::post('cartToOrderList', [RouteController::class, 'cartToOrderList']); // user_id, product_id,quantity, total_price, order_code

//order
Route::get('orders', [RouteController::class, 'getOrders']);
// get orders of a user
Route::get('orders/{user_id}', [RouteController::class, 'getOrder']); // user_id
Route::get('orders/delete/{order_id}', [RouteController::class, 'deleteOrder']); // order_id

//message  Read,Create,Delete
Route::get('messages', [RouteController::class, 'getMessages']);
Route::post('messages/create', [RouteController::class, 'createMessage']); // name, email, phone, subject, message
Route::get('messages/delete/{message_id}', [RouteController::class, 'deleteMessage']); // message_id




/**
 *   http://localhost:8000/api/users
 *   http://localhost:8000/api/products
 *   http://localhost:8000/api/categories
 *
 *   http://localhost:8000/api/create/category   require==> {'name'}
 */
