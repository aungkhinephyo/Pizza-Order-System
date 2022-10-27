<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    ## go to message list page
    public function listPage()
    {
        $messages = Contact::when(request('searchKey'), function ($query) {
            $searchKey = request('searchKey');
            $query->where('name', 'like', "%$searchKey%");
        })
            ->orderBy('created_at', 'asc')
            ->paginate(10);
        $messages->appends(request()->all());
        return view('admin.message.list', compact('messages'));
    }

    ## go to message details page
    public function messageDetails($id)
    {
        $message = Contact::where('id', $id)->first();
        return view('admin.message.details', compact('message'));
    }

    // delete message
    public function delete(Request $request)
    {
        Contact::where('id', $request->id)->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
