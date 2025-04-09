<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Workflow;
use App\Models\Attribute;
use App\Models\PaymentTerm;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\TransactionDetail;
use App\Models\TransactionPayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Models\TransactionDetailProduct;
use Illuminate\Support\Facades\Validator;
use App\Models\TransactionDetailProductSupplier;


class TransactionController extends Controller
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
            $data = Transaction::with('customer')->orderBy('id','desc')->orderBy('order_date','desc')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('customer', function ($row) {
                    return $row->customer->name ?? 'N/A'; 
                })
                ->addColumn('total_quantity', function ($row) {
                    return $row->total_quantity > 0 ? $row->total_quantity : '<span class="text-red-600"><b>0</b></span>'; 
                })
                ->addColumn('order_status', function ($row) {
                    $statusName = $row->workflow->name ?? 'N/A';
                    $statusColor = $row->workflow->color ?? 'primary'; 
                    return '<label class="badge bg-'.$statusColor.'">'. $statusName.'</label>'; 
                })
                ->addColumn('payment_status', function ($row) { 
                    if($row->payment_status == 'Unpaid') {
                       $text_color = 'text-red-600';
                    } elseif ($row->payment_status == 'Partial') {
                        $text_color = 'text-yellow-500';
                    } elseif ($row->payment_status == 'Paid') {
                        $text_color = 'text-green-600';
                    } else {
                        $text_color = 'text-grey-600';
                    }
                    return '<span class="'.$text_color.'">'. $row->payment_status.'</span>'; 
                })
                ->addColumn('order_date_format', function ($row) {
                    return date_format(date_create($row->order_date), 'd-m-Y'); 
                })
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex justify-content-center">';
                    $btn .= '<a href="' . route('transaction.show', $row->id) . '" class="btn btn-info btn-sm mx-1" title="Show Detail"><i class="fas fa-eye"></i></a>';
                    $btn .= '<a href="' . route('transaction.edit', $row->id) . '" class="btn btn-warning btn-sm mx-1" title="Edit"><i class="fas fa-edit"></i></a>';
                    $btn .= '<a href="' . route('transaction.add_payment', $row->id) . '" class="btn btn-success btn-sm mx-1" title="Add Payment"><i class="ti ti-cash"></i></a>';
                    $btn .= '<a href="' . route('transaction.destroy', $row->id) . '" class="btn btn-danger btn-sm mx-1" onclick="event.preventDefault(); if(confirm(\'Are you sure?\')) { document.getElementById(\'delete-form-' . $row->id . '\').submit(); }"><i class="fas fa-trash" title="Delete Transaction!"></i></a>';
                    $btn .= '<form id="delete-form-' . $row->id . '" action="' . route('transaction.destroy', $row->id) . '" method="POST" style="display: none;">' . csrf_field() . method_field('DELETE') . '</form>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action','order_status','payment_status','total_quantity']) // Allow HTML rendering for these columns
                ->make(true);
        }

        $content = 'transactions.index';
        return view('template', compact('content'));
    }

    public function create()
    {
        $customers = Customer::all();
        $content = 'transactions.create';
        return view('template', compact('content','customers'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'order_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        $count = Transaction::where('order_date','like',date('Y-m').'%')->withTrashed()->get()->count()+1; // count per month
        $transaction_number = "INV-".date('Ymd')."-".$count;

        $transaction_number_check = Transaction::where('transaction_number',$transaction_number)->withTrashed()->get()->count();
        if($transaction_number_check > 0){
            $transaction_number = $transaction_number."_".time();
        }

        $transaction = new Transaction();
        $transaction->customer_id = $request->customer_id;
        $transaction->order_date = $request->order_date;
        $transaction->transaction_number = $transaction_number;

        $transaction->save();
        $transaction_id = $transaction->id;

        if($request->submit_button == 'next'){
            return redirect()->route('transaction.add_product',$transaction_id)->with('success', 'Transaction created successfully.');
        }
        else {
            return redirect()->route('transaction.index')->with('success', 'Transaction created successfully.');
        }
        
    }

    public function show($id)
    {
        $transaction = Transaction::find($id);
        $transaction_products = TransactionDetail::where('transaction_id',$id)->
        with('product_transaction')->
        with('product_transaction_supplier')->get();
        $transaction_products_supplier = TransactionDetail::where('transaction_id',$id)->
        with('product_transaction_supplier')
        ->get();

        $content = 'transactions.show';
        return view('template',compact('transaction','content','transaction_products'));
    }
    
    public function edit($id)
    {
        $workflows = Workflow::all();
        $transaction = Transaction::find($id);
        $transaction_products = TransactionDetail::where('transaction_id',$id)->
        with('product_transaction')->
        with('product_transaction_supplier')->get();
        $transaction_products_supplier = TransactionDetail::where('transaction_id',$id)->
        with('product_transaction_supplier')
        ->get();

        $content = 'transactions.edit';
        return view('template',compact('transaction','content','transaction_products','workflows'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'order_status' => 'required',
            'transaction_id' => 'required',
            'total_discount' => 'required',
            'shipping_cost' => 'required',
        ]);

        // update from form edit transaction
        $transaction = Transaction::find($id);
        $transaction->order_status = $request->order_status;
        $transaction->total_discount = $request->total_discount;
        $transaction->shipping_cost = $request->shipping_cost;
        $transaction->save();


        // update transaction
        // update transaction
        $updatedTransaction = updateTransaction($id);
        $transaction = Transaction::find($id);
        $transaction->total_quantity = $updatedTransaction['totalQuantity'];
        $transaction->total_price = $updatedTransaction['totalPrice'];
        $transaction->grand_total = $updatedTransaction['grandTotal'];
        $transaction->remaining_balance = $updatedTransaction['remainingPayment'];
        $transaction->payment_status = $updatedTransaction['paymentStatus'];
        $transaction->save();

        // return redirect()->route('transaction.index')->with('success', 'Transaction updated successfully.');
        return redirect()->route('transaction.edit',$id)->with('success', 'Status order updated successfully.');
    }

    public function destroy($id)
    {
        Transaction::find($id)->delete();
        return redirect()->route('transaction.index')
                        ->with('success','Transaction deleted successfully');
    }

    // per product transaction:
    public function add_product($id)
    {
        $transaction = Transaction::where('id',$id)->with('customer')->first();
        $products = Product::all();
        $attributes = Attribute::all();
        $suppliers = Supplier::all();
        $content = 'transactions.add_product';
        return view('template', compact('content','transaction','attributes','products','suppliers'));
        
    }

    public function store_product(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'unit_price' => 'required',
            'quantity' => 'required',
            'transaction_id' => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }
    
        // data from transaction table
        $data_transaction = Transaction::where('id', $request->transaction_id)->first();
        $total_quantity = $data_transaction->total_quantity;
        $total_price = $data_transaction->total_price;
        $grand_total = $data_transaction->grand_total;
        $remaining_balance = $data_transaction->remaining_balance;

        // data from form input
        $qty = $request->quantity;
        $tot_amount = $request->unit_price * $qty;
                
        // Start a database transaction
        DB::beginTransaction();
    
        try {
            // Save to transaction_detail table
            $transaction_detail = new TransactionDetail();
            $transaction_detail->product_id = $request->product_id;
            $transaction_detail->quantity = $qty;
            $transaction_detail->unit_price = $request->unit_price;
            $transaction_detail->total_amount = $tot_amount;
            $transaction_detail->transaction_id = $request->transaction_id;
            $transaction_detail->save();
            $transaction_detail_id = $transaction_detail->id;
    
            // Save to transaction_detail_product
        if (!empty($request->attribute)) {
            foreach ($request->attribute as $key => $value) {
                if ($value != "") {
                    $attribute = Attribute::find($key); // Fetch the attribute to check its type

                    $transaction_detail_product = new TransactionDetailProduct();
                    $transaction_detail_product->detail_id = $transaction_detail_id;
                    $transaction_detail_product->attribute_id = $key;

                    if ($attribute && $attribute->type == 'image' && $request->hasFile("attribute.$key")) {
                        // Handle image upload
                        $file = $request->file("attribute.$key");
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('storage/uploads/product_details'), $fileName);

                        $transaction_detail_product->attribute_value = $fileName; // Save the file name
                    } else {
                        $transaction_detail_product->attribute_value = $value; // Save the text or other value
                    }

                    $transaction_detail_product->note = $request->transaction_id;
                    $transaction_detail_product->save();
                }
            }
        }
            // Save to transaction_detail_product_suppliers
            if (!empty($request->supplier_id)) {
                foreach ($request->supplier_id as $key => $value) {
                    $transaction_detail_product_suppliers = new TransactionDetailProductSupplier();
                    $transaction_detail_product_suppliers->detail_product_id = $transaction_detail_id;
                    $transaction_detail_product_suppliers->supplier_id = $value;
                    $transaction_detail_product_suppliers->save();
                }
            }

            // Update transaction
            $supplier = Transaction::find($request->transaction_id);
            $supplier->total_quantity = $total_quantity + $qty;
            $supplier->total_price = $total_price + $tot_amount;
            $supplier->grand_total = $grand_total + $tot_amount;
            $supplier->remaining_balance = $remaining_balance + $tot_amount;
            $supplier->save();
    
            // Commit the transaction if everything is successful
            DB::commit();
    
            if ($request->submit_button == 'add_another') {
                return redirect()->route('transaction.add_product', $request->transaction_id)
                                 ->with('success', 'Transaction created successfully.');
            } else {
                return redirect()->route('transaction.index')
                                 ->with('success', 'Transaction created successfully.');
            }
        } catch (\Exception $e) {
            // Rollback the transaction if any error occurs
            DB::rollBack();
    
            // Log the error for debugging
            \Log::error('Transaction Error: ' . $e->getMessage());
    
            // Redirect back with an error message
            return redirect()->back()
                             ->with('error', 'An error occurred while saving the transaction. Please try again.')
                             ->withInput();
        }
    }

    public function edit_product($id)
    {
        $transaction_detail = TransactionDetail::where('id',$id)->first();
        $transaction = Transaction::where('id',$transaction_detail->transaction_id)->with('customer')->first();
        $transaction_detail_attributes = TransactionDetailProduct::where('detail_id', $transaction_detail->id)
        ->pluck('attribute_value', 'attribute_id')
        ->toArray();

        // dd($transaction); exit;
        $transaction_detail_suppliers = TransactionDetailProductSupplier::where('detail_product_id', $transaction_detail->id)
        ->pluck('supplier_id')
        ->toArray();
        $products = Product::all();
        $attributes = Attribute::all();
        $suppliers = Supplier::all();
        $content = 'transactions.edit_product';

        return view('template', compact('content','transaction','attributes','products','suppliers','transaction_detail','transaction_detail_suppliers','transaction_detail_attributes'));
    }

    public function update_product(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'unit_price' => 'required',
            'quantity' => 'required',
            'transaction_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        // Fetch the transaction detail
        $transaction_detail = TransactionDetail::find($id);
        if (!$transaction_detail) {
            return redirect()->back()->with('error', 'Transaction detail not found.');
        }

        // Calculate the difference in quantity and total amount
        $old_quantity = $transaction_detail->quantity;
        $old_total_amount = $transaction_detail->total_amount;

        $new_quantity = $request->quantity;
        $new_total_amount = $request->unit_price * $new_quantity;

        $quantity_difference = $new_quantity - $old_quantity;
        $amount_difference = $new_total_amount - $old_total_amount;

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Update transaction_detail
            $transaction_detail->product_id = $request->product_id;
            $transaction_detail->quantity = $new_quantity;
            $transaction_detail->unit_price = $request->unit_price;
            $transaction_detail->total_amount = $new_total_amount;
            $transaction_detail->save();

            // Update transaction_detail_product
            TransactionDetailProduct::where('detail_id', $id)->delete();
            if (!empty($request->attribute)) {
                foreach ($request->attribute as $key => $value) {
                    if ($value != "") {
                        $attribute = Attribute::find($key);

                        $transaction_detail_product = new TransactionDetailProduct();
                        $transaction_detail_product->detail_id = $id;
                        $transaction_detail_product->attribute_id = $key;

                        // exit;
                        // // echo "<br>+".$attribute->type;
                        if ($attribute->type == 'image') {
                            if ($request->hasFile("attribute.$key")) {
                                // Handle new image upload
                                $file = $request->file("attribute.$key");
                                $fileName = time() . '_' . $file->getClientOriginalName();
                                $file->move(public_path('storage/uploads/product_details'), $fileName);
                        
                                $transaction_detail_product->attribute_value = $fileName;
                            } else {
                                // Use the existing image if no new file is uploaded
                                $transaction_detail_product->attribute_value = $request->input("attribute_old_image.$key");
                            }
                        } else {
                           
                            $transaction_detail_product->attribute_value = $value;
                            // echo "<br>-".$transaction_detail_product->attribute_value;
                           
                        }

                        $file = $request->file("attribute.$key");

                        $transaction_detail_product->note = $request->transaction_id;
                        $transaction_detail_product->save();
                    }
                }
            }

            // add exsisting file attribute
            if($request->file('attribute') == NULL && $request->attribute_old_image != NULL  ){
                
                foreach($request->attribute_old_image as $key => $value){
                    $transaction_detail_product = new TransactionDetailProduct();
                        $transaction_detail_product->detail_id = $id;
                        $transaction_detail_product->attribute_id = $key;

                    $transaction_detail_product->attribute_value = $request->input("attribute_old_image.$key");
                    $transaction_detail_product->save();
                    // echo $transaction_detail_product->attribute_id = $key;
                }
            }
           
            // Update transaction_detail_product_suppliers
            TransactionDetailProductSupplier::where('detail_product_id', $id)->delete();
            if (!empty($request->supplier_id)) {
                foreach ($request->supplier_id as $key => $value) {
                    $transaction_detail_product_supplier = new TransactionDetailProductSupplier();
                    $transaction_detail_product_supplier->detail_product_id = $id;
                    $transaction_detail_product_supplier->supplier_id = $value;
                    $transaction_detail_product_supplier->save();
                }
            }

            // Update transaction
            $transaction = Transaction::find($request->transaction_id);
            $transaction->total_quantity += $quantity_difference;
            $transaction->total_price += $amount_difference;
            $transaction->grand_total += $amount_difference;
            $transaction->remaining_balance += $amount_difference;
            $transaction->save();

            // Commit the transaction
            DB::commit();

            return redirect()->route('transaction.index')->with('success', 'Transaction product updated successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();

            \Log::error('Transaction Update Error: ' . $e->getMessage());

            return redirect()->back()
                             ->with('error', 'An error occurred while updating the transaction product. Please try again.')
                             ->withInput();
        }
    }

    public function destroy_product($transactionId, $transactionDetailId)
    {

        // Find the transaction detail by product ID and transaction ID
        $transactionDetail = TransactionDetail::where('id', $transactionDetailId)
            ->where('transaction_id', $transactionId)
            ->first();

        if (!$transactionDetail) {
            return redirect()->back()->with('error', 'Product not found in this transaction.');
        }
        // Delete the transaction detail
        $transactionDetail->delete();

        // Delete associated transaction_detail_product and transaction_detail_product_suppliers
        TransactionDetailProduct::where('detail_id', $transactionDetailId)->delete();
        TransactionDetailProductSupplier::where('detail_product_id', $transactionDetailId)->delete();


         // update transaction
         $updatedTransaction = updateTransaction($transactionId);
         $transaction = Transaction::find($transactionId);
         
         $transaction->total_quantity = $updatedTransaction['totalQuantity'];
         $transaction->total_price = $updatedTransaction['totalPrice'];
         $transaction->grand_total = $updatedTransaction['grandTotal'];
         $transaction->remaining_balance = $updatedTransaction['remainingPayment'];
         $transaction->payment_status = $updatedTransaction['paymentStatus'];
         $transaction->save();

        return redirect()->route('transaction.show', $transactionId)
                        ->with('success', 'Product deleted successfully.');
    }


    // Payment
    public function add_payment($transaction_id)
    {
        $content = 'transactions.add_payment';
        $transaction = Transaction::find($transaction_id);
        $payment_terms = PaymentTerm::get();
        $payments = TransactionPayment::where('transaction_id',$transaction_id)->get();

        return view('template', compact('content','transaction','payment_terms','payments'));
    }

    public function store_payment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_type' => 'required',
            'amount' => 'required',
            'payment_method' => 'required',
            'payment_date' => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }
    
        // Get Grand Total
        $existing_transaction = Transaction::where('id', $request->transaction_id)->first();
        $grand_total = $existing_transaction->grand_total;
        
        // Get existing total payment
        $payment_existing = TransactionPayment::where('transaction_id', $request->transaction_id)->sum('amount');
        $total_payment = $payment_existing + $request->amount;
        

        // Check if the total payment exceeds the grand total
        if ($total_payment > $grand_total) {
            return redirect()->back()
                             ->with('error', 'Total payment exceeds the grand total.')
                             ->withInput();
        }
        // Check if the payment date is in the future
        $payment_date = Carbon::parse($request->payment_date);
        $current_date = Carbon::now();
        if ($payment_date->isFuture()) {
            return redirect()->back()
                             ->with('error', 'Payment date cannot be in the future.')
                             ->withInput();
        }
        
        // Start a database transaction
        DB::beginTransaction();
    
        try {
            // Save to transaction_payments table
            $transaction_payment = new TransactionPayment();
            $transaction_payment->transaction_id = $request->transaction_id;
            $transaction_payment->payment_type = $request->payment_type;
            $transaction_payment->amount = $request->amount;
            $transaction_payment->payment_method = $request->payment_method;
            $transaction_payment->payment_date = $request->payment_date;
            $transaction_payment->image = $request->image;
            
            // Handle file upload for payment receipt
            if ($request->hasFile('image')) {
                $fileName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('storage/uploads/transactions'), $fileName);
                $transaction_payment->image = $fileName; // Save file name in the database
                
            }   
            $transaction_payment->save();

            // Check payment status
            if($total_payment == $grand_total){
                $payment_status = 'Paid';
            }else if($total_payment > 0 && $total_payment < $grand_total){
                $payment_status = 'Partial';
            }
            else{
                $payment_status = 'Unpaid';
            }
            // Update payment status in transaction table
            $transaction = Transaction::find($request->transaction_id);
            $transaction->payment_status = $payment_status;
            $transaction->remaining_balance = $grand_total - $total_payment;
            $transaction->save();
    
            // Commit the transaction if everything is successful
            DB::commit();
    
            return redirect()->route('transaction.add_payment', $request->transaction_id)
                                ->with('success', 'Payment created successfully.');
           
        } catch (\Exception $e) {
            // Rollback the transaction if any error occurs
            DB::rollBack();
    
            // Log the error for debugging
            \Log::error('Transaction Error: ' . $e->getMessage());
    
            // Redirect back with an error message
            return redirect()->back()
                             ->with('error', 'An error occurred while saving the transaction. Please try again.')
                             ->withInput();
        }
    }

    public function destroy_payment($transactionId, $transactionPaymentId)
    {
        // Find the transaction payment by ID
        $transactionPayment = TransactionPayment::where('id', $transactionPaymentId)
            ->where('transaction_id', $transactionId)
            ->first();

        if (!$transactionPayment) {
            return redirect()->back()->with('error', 'Payment not found in this transaction.');
        }

        // Delete the transaction payment
        $transactionPayment->delete();

        // Update the transaction's payment status and remaining payment
        $transaction = Transaction::find($transactionId);
        $total_payment = TransactionPayment::where('transaction_id', $transactionId)->sum('amount');
        $grand_total = $transaction->grand_total;

        if ($total_payment == 0) {
            $payment_status = 'Unpaid';
        } elseif ($total_payment < $grand_total) {
            $payment_status = 'Partial';
        } else {
            $payment_status = 'Paid';
        }

        $transaction->payment_status = $payment_status;
        $transaction->remaining_balance = $grand_total - $total_payment;
        $transaction->save();

        return redirect()->route('transaction.add_payment', $transactionId)
                        ->with('success', 'Payment deleted successfully.');
    }

    public function update_status_supplier(Request $request, $id)
    {
        // echo "<pre>";
        // print_r($request->all());
        // echo "</pre>";
        // exit;

        $validator = Validator::make($request->all(), [
            'supplier_status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        $transaction_detail_product = TransactionDetailProductSupplier::find($request->product_transaction_supplier_id);
        if (!$transaction_detail_product) {
            return redirect()->back()->with('error', 'Supplier status not found.');
        }
        // Update the supplier status
        $transaction_detail_product->process_status = $request->supplier_status;
        $transaction_detail_product->save();

        return redirect()->route('transaction.edit',$id)->with('success', 'Supplier status updated successfully.');
        
    }


}
