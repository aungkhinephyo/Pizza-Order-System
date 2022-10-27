<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    ## go to admin changePassword Page
    public function changePasswordPage()
    {
        return view('admin.account.changePassword');
    }

    // change admin account passowrd
    public function changePassword(Request $request)
    {
        /**
         *      all fields filled (required)
         *      new and confirm pw length > 6
         *      new pw = confirm pw
         *      old pw =  db pw
         *      update pw
         */
        $this->checkValidation($request);

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

    ## go to account details page
    public function detailsPage()
    {
        return view('admin.account.details');
    }

    ## go to edit account Details Page
    public function editDetailsPage()
    {
        return view('admin.account.editDetails');
    }

    // update details
    public function updateDetails(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();

        $this->accountValidation($request);
        $data = $this->getData($request);
        // dd($request->all());
        if ($request->hasFile('image')) {
            $old_img = $user->image;

            if ($old_img !== null) {
                Storage::delete('public/admin_profile/' . $old_img);
            }

            $post_img = $request->file('image');
            $save_img = uniqid() . '_' . $post_img->getClientOriginalName();
            $post_img->storeAs('public/admin_profile', $save_img);
            $data['image'] = $save_img;
        }

        $user->update($data);
        return redirect()->route('admin#account#detailsPage')->with('accountUpdate', 'successfully updated');
    }

    ## go to admin list Page
    public function listPage()
    {
        $admins = User::when(request('searchKey'), function ($query) {
            $searchKey = request('searchKey');
            $query->where('name', 'like', "%$searchKey%");
            // ->orWhere('email', 'like', "%$searchKey%")
            // ->orWhere('phone', 'like', "%$searchKey%")
            // ->orWhere('address', 'like', "%$searchKey%");
        })->whereNot('role', 'user')->paginate(5);
        $admins->appends(request()->all());
        return view('admin.account.list', compact('admins'));
    }

    ## go to user list Page
    public function userListPage()
    {
        $users = User::when(request('searchKey'), function ($query) {
            $searchKey = request('searchKey');
            $query->where('name', 'like', "%$searchKey%");
            // ->orWhere('email', 'like', "%$searchKey%")
            // ->orWhere('phone', 'like', "%$searchKey%")
            // ->orWhere('address', 'like', "%$searchKey%");
        })->where('role', 'user')->paginate(5);
        $users->appends(request()->all());
        return view('admin.account.user_list', compact('users'));
    }

    // delete admin account by president
    public function delete(Request $request)
    {
        User::where('id', $request->id)->delete();
        return response()->json(['status' => 'success'], 200);
    }

    // change role
    public function changeRole(Request $request)
    {
        $id = $request->id;
        $data = ['role' => $request->role];
        $person = User::where('id', $id)->first();

        $image = $person->image;

        if ($image !== null) {
            $from = '';
            $to = '';

            if ($person->role == 'admin') {
                $from = 'public/admin_profile/' . $image;
                $to = 'public/user_profile/' . $image;
            } elseif ($person->role == 'user') {
                $from = 'public/user_profile/' . $image;
                $to = 'public/admin_profile/' . $image;
            }

            Storage::copy($from, $to);
            Storage::delete($from);
        }
        $person->update($data);

        return response()->json(['status' => 'success'], 200);;
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
            'email' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'image' => 'file|image|max:1000'
        ];

        Validator::make($request->all(), $validationRules)->validate();
    }

    // password checkValidation
    private function checkValidation($request)
    {
        $validationRules = [
            'oldPassword' => 'required|min:6',
            'newPassword' => 'required|min:6',
            'confirmPassword' => 'required|min:6|same:newPassword',
        ];
        Validator::make($request->all(), $validationRules)->validate();
    }
}
