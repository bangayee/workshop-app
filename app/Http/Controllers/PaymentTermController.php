<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Setting;
use App\Models\PaymentTerm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;


class PaymentTermController extends Controller
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
            $data = PaymentTerm::get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<div class="d-flex justify-content-center">
                                <a href="' . route('payment_term.edit', $row->id) . '" class="btn btn-warning btn-sm mx-1"><i class="fas fa-edit"></i></a>
                                <a href="' . route('payment_term.destroy', $row->id) . '" class="btn btn-danger btn-sm mx-1" onclick="event.preventDefault(); if(confirm(\'Are you sure?\')) { document.getElementById(\'delete-form-' . $row->id . '\').submit(); }"><i class="fas fa-trash"></i></a>
                                <form id="delete-form-' . $row->id . '" action="' . route('payment_term.destroy', $row->id) . '" method="POST" style="display: none;">' . csrf_field() . method_field('DELETE') . '</form>
                            </div>';
                })
                ->rawColumns(['action']) 
                ->make(true);
        }

        $content = 'payment_terms.index';
        return view('template', compact('content'));
    }

    public function create()
    {
        $content = 'payment_terms.create';
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

        $payment_term = new PaymentTerm();
        $payment_term->name = $request->name;
        $payment_term->note = $request->note;
        $payment_term->save();

        return redirect()->route('payment_term.index')->with('success', 'PaymentTerm created successfully.');
    }

    public function edit($id)
    {
        $payment_term = PaymentTerm::find($id);
        $content = 'payment_terms.edit';
        return view('template', compact('content','payment_term'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $payment_term = PaymentTerm::find($id);
        $payment_term->name = $request->name;
        $payment_term->note = $request->note;
        $payment_term->save();

        return redirect()->route('payment_term.index')->with('success', 'PaymentTerm updated successfully.');
    }

    public function destroy($id)
    {
        PaymentTerm::find($id)->delete();
        return redirect()->route('payment_term.index')
                        ->with('success','PaymentTerm deleted successfully');
    }
    

}
