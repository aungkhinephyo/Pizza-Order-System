<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    ## go to admin category List page
    public function listPage(Request $request)
    {
        // $categories = Category::orderBy('id','desc')->paginate(4);

        $categories = Category::when(request('searchKey'),function($query){
            $searchKey = request('searchKey');
            $query->where('name','like',"%$searchKey%");
        })->orderBy('updated_at','desc')->paginate(4);
        $categories->appends($request->all());
        return view('admin.category.list',compact('categories'));
    }

    ## go to admin categoty create page
    public function createPage() {
        return view('admin.category.create');
    }

    // create new categoty
    public function create(Request $request) {
        // dd($request->all());
        $this->checkValidation($request);
        $data = $this->getData($request);
        Category::create($data);
        return redirect()->route('admin#category#list')->with('createSuccess','successfully created');
    }

    //delete category
    public function delete($id) {
        Category::where('id',$id)->delete();
        return back()->with('deleteSuccess','successfully deleted');
    }

    ## go to editPage
    public function editPage($id){
        $category = Category::where('id',$id)->first();
        // dd($category);
        return view('admin.category.edit',compact('category'));
    }

    // edit and update category
    public function update(Request $request,$id){
        // dd($request->all());
        $update_id = $id;
        $this->checkValidation($request);
        $data = $this->getData($request);

        $old_name = Category::select('name')->where('id',$update_id)->first()->toArray();

        Category::where('id',$update_id)->update($data);

        if($data['name'] !== $old_name['name']) {
            return redirect()->route('admin#category#list')->with('editSuccess','successfully updated');
        }else {
            return redirect()->route('admin#category#list')->with('noEdit','no update');
        }

        // dd($id,$request->all());
    }

    // get create data
    private function getData($request) {
        return [
            'name' => $request->categoryName
        ];
    }
    // Validation
    private function checkValidation($request){
        // $unique_category = Category::where('id',$request->categoryId)->first();
        // dd($unique_category);
        Validator::make($request->all(),
        [
            'categoryName' => 'required|unique:categories,name,' . $request->categoryId
        ])->validate();

    }
}
