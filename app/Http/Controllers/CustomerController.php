<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Setting;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;


class CustomerController extends Controller
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
            $data = Customer::get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<div class="d-flex justify-content-center">' .
                        '<a href="' . route('customer.show', $row->id) . '" class="btn btn-info btn-sm mx-1" title="View"><i class="fas fa-eye"></i></a>' .
                        '<a href="' . route('customer.edit', $row->id) . '" class="btn btn-warning btn-sm mx-1" title="Edit"><i class="fas fa-edit"></i></a>' .
                        '<a href="' . route('customer.destroy', $row->id) . '" class="btn btn-danger btn-sm mx-1" title="Delete" onclick="event.preventDefault(); if(confirm(\'Are you sure?\')) { document.getElementById(\'delete-form-' . $row->id . '\').submit(); }"><i class="fas fa-trash"></i></a>' .
                        '<form id="delete-form-' . $row->id . '" action="' . route('customer.destroy', $row->id) . '" method="POST" style="display: none;">' . csrf_field() . method_field('DELETE') . '</form>' .
                    '</div>';
                })
                ->rawColumns(['action']) // Allow HTML rendering for these columns
                ->make(true);
        }

        $content = 'customers.index';
        return view('template', compact('content'));
    }

    public function create()
    {
        $content = 'customers.create';
        return view('template', compact('content'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        $customer = new Customer();
        $customer->name = $request->name;
        $customer->phone_number = $request->phone_number;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->city = $request->city;
        $customer->province = $request->province;
        $customer->company = $request->company;
        $customer->save();

        return redirect()->route('customer.index')->with('success', 'Customer created successfully.');
    }

    public function edit($id)
    {
        $customer = Customer::find($id);
        $content = 'customers.edit';
        return view('template', compact('content','customer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $customer = Customer::find($id);
        $customer->name = $request->name;
        $customer->phone_number = $request->phone_number;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->city = $request->city;
        $customer->province = $request->province;
        $customer->company = $request->company;
        $customer->save();

        return redirect()->route('customer.index')->with('success', 'Customer updated successfully.');
    }

    public function show($id)
    {
        $customer = Customer::find($id);
        $content = 'customers.show';

        return view('template',compact('customer','content'));
    }


    public function destroy($id)
    {
        Customer::find($id)->delete();
        return redirect()->route('customer.index')
                        ->with('success','Customer deleted successfully');
    }
    

}
