<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    ## go to admin product List page
    public function listPage(Request $request)
    {

        $products = Product::select('products.*', 'categories.name as category_name')
            ->when(request('searchKey'), function ($query) {
                $searchKey = request('searchKey');
                $query->where('products.name', 'like', "%$searchKey%");
            })
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->orderBy('products.updated_at', 'desc')
            ->paginate(3);
        $products->appends($request->all());
        return view('admin.product.list', compact('products'));
    }

    ## go to admin categoty create page
    public function createPage()
    {
        $categories = Category::select('id', 'name')->get();
        return view('admin.product.create', compact('categories'));
    }

    // create new categoty
    public function create(Request $request)
    {
        // dd($request->all());
        $this->checkValidation($request, 'create');
        $data = $this->getData($request);

        $save_img = uniqid() . '_' . $request->file('productImage')->getClientOriginalName();
        $request->file('productImage')->storeAs('public/product_img', $save_img);
        $data['image'] = $save_img;

        if($request->file('pizzaImage')){
            $fileName = uniqid() . '_' . $request->file('pizzaImage')->getClientOriginalName();
            $request->file('pizzaImage')->storeAs('public', $fileName);
            $data['image'] = $fileName;
        }

        Product::create($data);
        return redirect()->route('admin#product#listPage')->with('createSuccess', 'successfully created');
    }

    //delete product
    public function delete($id)
    {
        Product::where('id', $id)->delete();
        return back()->with('deleteSuccess', 'successfully deleted');
    }

    ## go to detailsPage
    public function detailsPage($id)
    {
        $product = Product::select('products.*', 'categories.name as category_name')
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->where('products.id', $id)
            ->first();
        return view('admin.product.details', compact('product'));
    }

    ## go to editPage
    public function editPage($id)
    {
        $categories = Category::select('id', 'name')->get();
        $product = Product::where('id', $id)->first();
        return view('admin.product.editDetails', compact('product', 'categories'));
    }

    // edit and update product
    public function update(Request $request)
    {
        $update_id = $request->productId;
        $product = Product::where('id', $update_id)->first();

        $this->checkValidation($request, 'update');
        $data = $this->getData($request);

        // dd($request->all(), $update_id, $product->toArray(), $data);

        if ($request->hasFile('productImage')) {
            $old_img = $product->image;
            if ($old_img !== null) {
                Storage::delete('public/product_img/' . $old_img);
            }
            $post_img = $request->file('productImage');
            $save_img = uniqid() . '_' . $post_img->getClientOriginalName();
            $post_img->storeAs('public/product_img', $save_img);
            $data['image'] = $save_img;
        }

        $product->update($data);
        return redirect()->route('admin#product#listPage')->with('editSuccess', 'successfully updated');
    }

    // get create data
    private function getData($request)
    {
        return [
            'name' => $request->productName,
            'category_id' => $request->productCategory,
            'description' => $request->productDescription,
            'price' => $request->productPrice,
            'waiting_time' => $request->productTime,
        ];
    }
    // Validation
    private function checkValidation($request, $action)
    {
        $id = $request->productId;

        $validationRules = [
            'productName' => 'required|unique:products,name,' . $id,
            'productCategory' => 'required',
            'productDescription' => 'required|min:10',
            'productPrice' => 'required',
            'productTime' => 'required',
        ];

        $validationRules['productImage'] = $action == 'create' ? 'required|image|max:1000|file' : 'image|max:1000|file';

        Validator::make($request->all(), $validationRules)->validate();
    }
}
