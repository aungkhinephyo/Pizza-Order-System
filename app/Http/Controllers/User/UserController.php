<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    ## go to home page
    public function homePage()
    {
        $products = Product::when(request('searchKey'), function ($query) {
            $searchKey = request('searchKey');
            $query->where('name', 'like', "%$searchKey%");
        })->orderBy('updated_at', 'desc')->get();
        $categories = Category::get();
        $cart = Cart::where('user_id', Auth::user()->id)->get();
        $history = Order::where('user_id', Auth::user()->id)->get();
        return view('user.main.home', compact('products', 'categories', 'cart', 'history'));
    }

    // home page filter category
    public function filterCategory($id)
    {
        $products = Product::where('category_id', $id)->orderBy('created_at', 'desc')->get();
        $categories = Category::get();
        $cart = Cart::where('user_id', Auth::user()->id)->get();
        $history = Order::where('user_id', Auth::user()->id)->get();
        return view('user.main.home', compact('products', 'categories', 'cart', 'history'));
    }

    ## go to product details page
    public function prodcutDetailsPage($id)
    {
        $product = Product::where('id', $id)->first();
        $products = Product::where('category_id', $product->category_id)->get();
        return view('user.main.details', compact('product', 'products'));
    }

    ## go to cart  page
    public function cartPage()
    {
        $cart = Cart::select('carts.*', 'products.name', 'products.price', 'products.image')->where('user_id', Auth::user()->id)
            ->leftJoin('products', 'carts.product_id', 'products.id')
            ->get();

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item->price * $item->quantity;
        }
        // dd($subtotal);
        return view('user.main.cart', compact('cart', 'subtotal'));
    }

    ## go to history page
    public function historyPage()
    {
        $orders = Order::where('user_id', Auth::user()->id)->orderBy('updated_at', 'desc')->paginate(5);
        $orders->appends(request()->all());
        return view('user.main.history', compact('orders'));
    }

    ## go to contact page
    public function contactPage()
    {
        return view('user.main.contact');
    }

    // send message
    public function sendMessage(Request $request)
    {
        $this->messageValidation($request);
        $data = $this->getMessage($request);
        Contact::create($data);
        return redirect()->route('user#contactPage')->with('sent', 'successfully sent');
    }
    // =============================== Account =========================================/

    ## go to account details page
    public function accountDetailsPage()
    {
        $id = Auth::user()->id;
        return view('user.account.details');
    }

    public function changePasswordPage()
    {
        $id = Auth::user()->id;
        return view('user.account.changePassword');
    }

    // change user account passowrd
    public function changePassword(Request $request)
    {
        $this->passwordCheckValidation($request);

        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $db_password = $user->password; // hash value
        $old_passwrod = $request->oldPassword;

        if (Hash::check($old_passwrod, $db_password)) {
            $data = ['password' => Hash::make($request->newPassword)];
            User::where('id', $id)->update($data);
            Auth::logout();
            return redirect()->route('auth#loginPage')->with('passwordChanged', 'successfully updated');
        } else {
            return back()->with(['passwordWrong' => 'fail']);
        }
    }

    ## go to edit account Details Page
    public function editDetailsPage()
    {
        return view('user.account.editDetails');
    }

    // update details
    public function updateDetails(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();

        $this->accountValidation($request);
        $data = $this->getData($request);
        // dd($user->toArray());
        if ($request->hasFile('image')) {
            $old_img = $user->image;

            if ($old_img !== null) {
                Storage::delete('public/user_profile/' . $old_img);
            }

            $post_img = $request->file('image');
            $save_img = uniqid() . '_' . $post_img->getClientOriginalName();
            $post_img->storeAs('public/user_profile', $save_img);
            $data['image'] = $save_img;
        }

        $user->update($data);
        return redirect()->route('user#account#detailsPage')->with('accountUpdate', 'successfully updated');
    }

    // ========================= Private Function ==========================================/

    // password checkValidation
    private function passwordCheckValidation($request)
    {
        $validationRules = [
            'oldPassword' => 'required|min:6',
            'newPassword' => 'required|min:6',
            'confirmPassword' => 'required|min:6|same:newPassword',
        ];
        Validator::make($request->all(), $validationRules)->validate();
    }

    // get user update data
    private function getData($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address,
        ];
    }

    // account checkValidation
    private function accountValidation($request)
    {
        $validationRules = [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|min:10',
            'gender' => 'required',
            'address' => 'required',
            'image' => 'file|image|max:1000'
        ];

        Validator::make($request->all(), $validationRules)->validate();
    }

    //========================= send message ===================================
    // get message info
    private function getMessage($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message
        ];
    }

    // message Validation
    private function messageValidation($request)
    {
        $validationRules = [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|min:10',
            'subject' => 'required',
            'message' => 'required'
        ];

        Validator::make($request->all(), $validationRules)->validate();
    }
}
