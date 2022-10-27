<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\User\AjaxController;
use App\Http\Controllers\User\UserController;

/* ============================Start Login, Register =========================== */

Route::middleware(['login_auth'])->group(function () {
    Route::redirect('/', 'loginPage');
    Route::get('loginPage', [AuthController::class, 'loginPage'])->name('auth#loginPage');
    Route::get('registerPage', [AuthController::class, 'registerPage'])->name('auth#registerPage');
});

/* ============================End Login, Register =========================== */


Route::middleware(['auth'])->group(function () {

    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    /* ============================Start Admin =========================== */
    Route::middleware(['admin_auth'])->group(function () {

        /* admin account */
        Route::prefix('admin/account')->group(function () {
            Route::get('changePasswordPage', [AdminController::class, 'changePasswordPage'])->name('admin#account#changePasswordPage');
            Route::post('changePassword', [AdminController::class, 'changePassword'])->name('admin#account#changePassword');
            Route::get('detailsPage', [AdminController::class, 'detailsPage'])->name('admin#account#detailsPage');
            Route::get('editDetailsPage', [AdminController::class, 'editDetailsPage'])->name('admin#account#editDetailsPage');
            Route::post('updateDetails', [AdminController::class, 'updateDetails'])->name('admin#account#updateDetails');
            /* admin lists */
            Route::get('listPage', [AdminController::class, 'listPage'])->name('admin#account#listPage');
            /* user lists */
            Route::get('userListPage', [AdminController::class, 'userListPage'])->name('admin#account#user#listPage');
            /* change role */
            Route::get('changeRole', [AdminController::class, 'changeRole'])->name('admin#account#changeRole');
            /* account delete */
            Route::get('delete', [AdminController::class, 'delete'])->name('ajax#admin#account#delete');
        });

        /* Category */
        Route::group(['prefix' => 'admin/category'], function () {

            Route::get('listPage', [CategoryController::class, 'listPage'])->name('admin#category#list');
            Route::get('createPage', [CategoryController::class, 'createPage'])->name('admin#category#createPage');
            Route::post('create', [CategoryController::class, 'create'])->name('admin#category#create');
            Route::get('delete/{id}', [CategoryController::class, 'delete'])->name('admin#category#delete');
            Route::get('editPage/{id}', [CategoryController::class, 'editPage'])->name('admin#category#editPage');
            Route::post('update/{id}', [CategoryController::class, 'update'])->name('admin#category#update');
        });

        /* product */
        Route::prefix('admin/product')->group(function () {
            Route::get('listPage', [ProductController::class, 'listPage'])->name('admin#product#listPage');
            Route::get('createPage', [ProductController::class, 'createPage'])->name('admin#product#createPage');
            Route::post('create', [ProductController::class, 'create'])->name('admin#product#create');
            Route::get('delete/{id}', [ProductController::class, 'delete'])->name('admin#product#delete');
            Route::get('detailsPage/{id}', [ProductController::class, 'detailsPage'])->name('admin#product#detailsPage');
            Route::get('editPage/{id}', [ProductController::class, 'editPage'])->name('admin#product#editPage');
            Route::post('update', [ProductController::class, 'update'])->name('admin#product#update');
        });

        /* oder */
        Route::prefix('admin/order')->group(function () {
            Route::get('listPage', [OrderController::class, 'listPage'])->name('admin#order#listPage');
            /* sorting orders */
            Route::get('sortingOrders', [OrderController::class, 'sortingOrders'])->name('ajax#admin#order#sortingOrders');
            /* change status */
            Route::get('changeStatus', [OrderController::class, 'changeStatus'])->name('ajax#admin#order#changeStatus');
            Route::get('orderDetails/{orderCode}', [OrderController::class, 'orderDetails'])->name('admin#order#orderDetails');
            Route::get('delete', [OrderController::class, 'delete'])->name('ajax#admin#account#delete');
        });

        /* contact and messages */
        Route::prefix('admin/contact')->group(function () {
            Route::get('listPage', [ContactController::class, 'listPage'])->name('admin#contact#listPage');
            Route::get('messageDetails/{id}', [ContactController::class, 'messageDetails'])->name('admin#contact#messageDetails');
            Route::get('delete', [ContactController::class, 'delete'])->name('ajax#admin#account#delete');
        });
    });

    /* ============================End Admin =========================== */

    /* ============================Start User =========================== */
    Route::middleware(['user_auth'])->group(function () {
        /* pages */
        Route::get('homePage', [UserController::class, 'homePage'])->name('user#homePage');
        Route::get('prodcutDetailsPage/{id}', [UserController::class, 'prodcutDetailsPage'])->name('user#prodcutDetailsPage');
        Route::get('cartPage', [UserController::class, 'cartPage'])->name('user#cartPage');
        Route::get('historyPage', [UserController::class, 'historyPage'])->name('user#historyPage');
        Route::get('contactPage', [UserController::class, 'contactPage'])->name('user#contactPage');
        /* filter category */
        Route::get('productCategory/filter/{id}', [UserController::class, 'filterCategory'])->name('filterCategory');
        /* sent message */
        Route::post('sendMessage', [UserController::class, 'sendMessage'])->name('sendMessage');

        /* user account */
        Route::prefix('user/account')->group(function () {
            Route::get('detailsPage', [UserController::class, 'accountDetailsPage'])->name('user#account#detailsPage');
            Route::get('changePasswordPage', [UserController::class, 'changePasswordPage'])->name('user#account#changePasswordPage');
            Route::post('changePassword', [UserController::class, 'changePassword'])->name('user#account#changePassword');
            Route::get('editDetailsPage', [UserController::class, 'editDetailsPage'])->name('user#account#editDetailsPage');
            Route::post('updateDetails', [UserController::class, 'updateDetails'])->name('user#account#updateDetails');
        });

        Route::prefix('user/ajax')->group(function () {
            /* sorting products */
            Route::get('sortingProducts', [AjaxController::class, 'sortingProducts'])->name('ajax#user#sortingProducts');
            Route::get('addToCart', [AjaxController::class, 'addToCart'])->name('ajax#user#addToCart');
            Route::get('addViewCount', [AjaxController::class, 'addViewCount'])->name('ajax#user#addViewCount');
            Route::get('addToOrderList', [AjaxController::class, 'addToOrderList'])->name('ajax#user#addToOrderList');
            Route::get('removeRow', [AjaxController::class, 'removeRow'])->name('ajax#user#removeRow');
            Route::get('clearCart', [AjaxController::class, 'clearCart'])->name('ajax#user#clearCart');
        });
    });

    /* ============================End User =========================== */
});

// Route::get('webTest', function () {
//     $data = ['stauts' => 'web'];
//     return response()->json($data, 200);
// });
