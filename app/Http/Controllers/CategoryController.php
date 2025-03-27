<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Setting;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;


class CategoryController extends Controller
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
            $data = Category::get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="' . route('category.show', $row->id) . '" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a> ';
                    $btn .= '<a href="' . route('category.edit', $row->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a> ';
                    $btn .= '<a href="' . route('category.destroy', $row->id) . '" class="btn btn-danger btn-sm" onclick="event.preventDefault(); if(confirm(\'Are you sure?\')) { document.getElementById(\'delete-form-' . $row->id . '\').submit(); }"><i class="fas fa-trash"></i></a>';
                    $btn .= '<form id="delete-form-' . $row->id . '" action="' . route('category.destroy', $row->id) . '" method="POST" style="display: none;">' . csrf_field() . method_field('DELETE') . '</form>';
                    return $btn;
                })
                ->rawColumns(['action']) // Allow HTML rendering for these columns
                ->make(true);
        }

        $content = 'categories.index';
        return view('template', compact('content'));
    }

    public function create()
    {
        $content = 'categories.create';
        return view('template', compact('content'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;

    
        $category->save();

        return redirect()->route('category.index')->with('success', 'Category created successfully.');
    }

    public function edit($id)
    {
        $category = Category::find($id);
        $content = 'categories.edit';
        return view('template', compact('content','category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $category = Category::find($id);
        $category->name = $request->name;
        $category->description = $request->description;

        $category->save();

        return redirect()->route('category.index')->with('success', 'Category updated successfully.');
    }

    public function show($id)
    {
        $category = Category::find($id);
        $content = 'categories.show';

        return view('template',compact('category','content'));
    }


    public function destroy($id)
    {
        Category::find($id)->delete();
        return redirect()->route('category.index')
                        ->with('success','Category deleted successfully');
    }
    

}
