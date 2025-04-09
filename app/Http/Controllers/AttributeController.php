<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Setting;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;


class AttributeController extends Controller
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
            $data = Attribute::get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex justify-content-center">';
                    $btn .= '<a href="' . route('attribute.edit', $row->id) . '" class="btn btn-warning btn-sm mx-1"><i class="fas fa-edit"></i></a> ';
                    $btn .= ' <a href="' . route('attribute.destroy', $row->id) . '" class="btn btn-danger btn-sm" onclick="event.preventDefault(); if(confirm(\'Are you sure?\')) { document.getElementById(\'delete-form-' . $row->id . '\').submit(); }"><i class="fas fa-trash"></i></a>';
                    $btn .= '<form id="delete-form-' . $row->id . '" action="' . route('attribute.destroy', $row->id) . '" method="POST" style="display: none;">' . csrf_field() . method_field('DELETE') . '</form>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action']) 
                ->make(true);
        }

        $content = 'attributes.index';
        return view('template', compact('content'));
    }

    public function create()
    {
        $content = 'attributes.create';
        return view('template', compact('content'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        $attribute = new Attribute();
        $attribute->name = $request->name;
        $attribute->note = $request->note;
        $attribute->type = $request->type;
        $attribute->save();

        return redirect()->route('attribute.index')->with('success', 'Attribute created successfully.');
    }

    public function edit($id)
    {
        $attribute = Attribute::find($id);
        $content = 'attributes.edit';
        return view('template', compact('content','attribute'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
        ]);

        $attribute = Attribute::find($id);
        $attribute->name = $request->name;
        $attribute->note = $request->note;
        $attribute->type = $request->type;
        $attribute->save();

        return redirect()->route('attribute.index')->with('success', 'Attribute updated successfully.');
    }

    public function destroy($id)
    {
        Attribute::find($id)->delete();
        return redirect()->route('attribute.index')
                        ->with('success','Attribute deleted successfully');
    }
    

}
