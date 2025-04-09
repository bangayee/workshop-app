<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    protected $settings;

    public function __construct()
    {
        $this->settings = Setting::all();

        foreach ($this->settings as $setting) {
            $this->{$setting->setting_name} = $setting->value;
            View::share($setting->setting_name, $setting->value); // Share each setting globally
        }

    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::with('category')->select('id', 'name', 'category_id', 'price', 'image')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('category', function ($row) {
                    return $row->category->name ?? 'N/A'; // Assuming a relationship exists
                })
                ->addColumn('image', function ($row) {
                    if ($row->image) {
                        $imageUrl = asset('storage/uploads/products/' . $row->image);
                        return '<a href="#" class="image-link" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="' . $imageUrl . '">
                                    <img src="' . $imageUrl . '" alt="Product Image" style="width: 50px; height: 50px; object-fit: cover;">
                                </a>';
                    }
                    return 'No Image';
                })
                ->addColumn('action', function($row){
                    return '<div class="d-flex justify-content-center">
                                <a href="' . route('product.show', $row->id) . '" class="btn btn-info btn-sm mx-1"><i class="fas fa-eye"></i></a>
                                <a href="' . route('product.edit', $row->id) . '" class="btn btn-warning btn-sm mx-1"><i class="fas fa-edit"></i></a>
                                <a href="' . route('product.destroy', $row->id) . '" class="btn btn-danger btn-sm mx-1" onclick="event.preventDefault(); if(confirm(\'Are you sure?\')) { document.getElementById(\'delete-form-' . $row->id . '\').submit(); }"><i class="fas fa-trash"></i></a>
                                <form id="delete-form-' . $row->id . '" action="' . route('product.destroy', $row->id) . '" method="POST" style="display: none;">' . csrf_field() . method_field('DELETE') . '</form>
                            </div>';
                })
                ->rawColumns(['image', 'action']) // Allow HTML rendering for these columns
                ->make(true);
        }

        $content = 'products.index';
        return view('template', compact('content'));
    }

    public function create()
    {
        $categories = Category::all();
        $content = 'products.create';
        return view('template', compact('content','categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg|max:2048', // Validate file type and size
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;

        // Handle file upload
        if ($request->hasFile('image')) {
            $fileName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('storage/uploads/products'), $fileName);
            $product->image = $fileName; // Save file name in the database
        }

        $product->save();

        return redirect()->route('product.index')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        $content = 'products.edit';
        return view('template', compact('content','product','categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048', // Allow image to be null and validate file type and size
        ]);

        $product = Product::find($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;

        // Handle file upload
        if ($request->hasFile('image')) {
            $fileName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('storage/uploads/products'), $fileName);
            $product->image = $fileName; // Save file name in the database
        }

        $product->save();

        return redirect()->route('product.index')->with('success', 'Product updated successfully.');
    }

    public function show($id)
    {
        $product = Product::find($id);
        $content = 'products.show';

        return view('template',compact('product','content'));
    }


    public function destroy($id)
    {
        Product::find($id)->delete();
        return redirect()->route('product.index')
                        ->with('success','Product deleted successfully');
    }
    

}
