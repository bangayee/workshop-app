<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Payment;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use App\Models\TransactionDetailProductSupplier;


class OrderSupplierController extends Controller
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
        // $data = TransactionDetailProductSupplier::first();

            // dd($data->supplier->name);
            // dd($data->workflow->name);
            // dd($data->detail_product->transaction->transaction_number);
            // dd($data->detail_product->product->name);
            // dd($data->detail_product->transaction->customer->name);
            // exit;

        if ($request->ajax()) {
            $data = TransactionDetailProductSupplier::get();

            // return $data;
            // exit;

            return Datatables::of($data)
                ->addColumn('supplier_name', function ($row) {
                    return  $row->supplier->name; 
                })
                ->addColumn('status', function ($row) {
                    return  $row->workflow->name; 
                })
                ->addColumn('transaction_number', function ($row) {
                    return  $row->detail_product->transaction->transaction_number; 
                })
                ->addColumn('product_name', function ($row) {
                    return $row->detail_product->product->name; 
                })
                ->addColumn('customer', function ($row) {
                    return $row->detail_product->transaction->customer->name; 
                })
                ->addIndexColumn()
                // ->rawColumns(['image','amount']) // Allow HTML rendering for these columns
                ->make(true);
        }

        $content = 'order_suppliers.index';
        return view('template', compact('content'));
    }


}
