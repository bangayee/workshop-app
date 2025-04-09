<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Setting;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;


class SupplierController extends Controller
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
            $data = Supplier::get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex justify-content-center">';
                    $btn .= '<a href="' . route('supplier.show', $row->id) . '" class="btn btn-info btn-sm mx-1"><i class="fas fa-eye"></i></a>';
                    $btn .= '<a href="' . route('supplier.edit', $row->id) . '" class="btn btn-warning btn-sm mx-1"><i class="fas fa-edit"></i></a>';
                    $btn .= '<a href="' . route('supplier.destroy', $row->id) . '" class="btn btn-danger btn-sm mx-1" onclick="event.preventDefault(); if(confirm(\'Are you sure?\')) { document.getElementById(\'delete-form-' . $row->id . '\').submit(); }"><i class="fas fa-trash"></i></a>';
                    $btn .= '<form id="delete-form-' . $row->id . '" action="' . route('supplier.destroy', $row->id) . '" method="POST" style="display: none;">' . csrf_field() . method_field('DELETE') . '</form>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action']) // Allow HTML rendering for these columns
                ->make(true);
        }

        $content = 'suppliers.index';
        return view('template', compact('content'));
    }

    public function create()
    {
        $content = 'suppliers.create';
        return view('template', compact('content'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'company' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        $supplier = new Supplier();
        $supplier->name = $request->name;
        $supplier->phone_number = $request->phone_number;
        $supplier->email = $request->email;
        $supplier->address = $request->address;
        $supplier->note = $request->note;
        $supplier->company = $request->company;
        $supplier->save();

        return redirect()->route('supplier.index')->with('success', 'Supplier created successfully.');
    }

    public function edit($id)
    {
        $supplier = Supplier::find($id);
        $content = 'suppliers.edit';
        return view('template', compact('content','supplier'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $supplier = Supplier::find($id);
        $supplier->name = $request->name;
        $supplier->phone_number = $request->phone_number;
        $supplier->email = $request->email;
        $supplier->address = $request->address;
        $supplier->note = $request->note;
        $supplier->company = $request->company;
        $supplier->save();

        return redirect()->route('supplier.index')->with('success', 'Supplier updated successfully.');
    }

    public function show($id)
    {
        $supplier = Supplier::find($id);
        $content = 'suppliers.show';

        return view('template',compact('supplier','content'));
    }


    public function destroy($id)
    {
        Supplier::find($id)->delete();
        return redirect()->route('supplier.index')
                        ->with('success','Supplier deleted successfully');
    }
    

}
