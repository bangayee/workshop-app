<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Payment;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;


class PaymentController extends Controller
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
            $data = Payment::get();

            return Datatables::of($data)
                ->addColumn('payment_type', function ($row) {
                    return  $row->payment_term->note; 
                })
                ->addColumn('transaction_number', function ($row) {
                    return  $row->transaction->transaction_number; 
                })
                ->addColumn('customer', function ($row) {
                    return  $row->transaction->customer->name; 
                })
                ->addColumn('payment_date', function ($row) {
                    return date_format(date_create($row->payment_date), 'd-m-Y'); 
                })
                ->addColumn('amount', function ($row) {
                    return '<div style="text-align: right;">' . number_format($row->amount, 0, ",", ".") . '</div>';
                })
                ->addColumn('image', function ($row) {
                    if ($row->image) {
                        $imageUrl = asset('storage/uploads/transactions/' . $row->image);
                        return '<a href="#" class="image-link" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="' . $imageUrl . '">
                                    <img src="' . $imageUrl . '" alt="Payment Image" style="width: 50px; height: 50px; object-fit: cover;">
                                </a>';
                    }
                    return 'No Image';
                })
                ->addIndexColumn()
                ->rawColumns(['image','amount']) // Allow HTML rendering for these columns
                ->make(true);
        }

        $content = 'payments.index';
        return view('template', compact('content'));
    }


}
