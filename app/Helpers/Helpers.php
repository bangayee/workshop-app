<?php

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\TransactionPayment;

if (!function_exists('paymentStatus')) {
    function paymentStatus($transactionId)
    {
        $transaction = Transaction::first();  
        return $transaction;
    }
}

if (!function_exists('updateTransaction')) {
    function updateTransaction($transactionId)
    {
       
        $total_quantity = TransactionDetail::where('transaction_id', $transactionId)->sum('quantity');
        $total_price = TransactionDetail::where('transaction_id', $transactionId)->sum('total_amount');
        $total_discount = Transaction::where('id', $transactionId)->sum('total_discount');
        $shipping_cost = Transaction::where('id', $transactionId)->sum('shipping_cost');
        $grand_total = $total_price - $total_discount + $shipping_cost;

        $payments = TransactionPayment::where('transaction_id', $transactionId)->sum('amount');

        $remaining_payment = $grand_total - $payments;

        if($remaining_payment == $grand_total) {
            $payment_status = 'Unpaid';
        }
        else if($remaining_payment == 0) {
            $payment_status = 'Paid';
        }
        else if($remaining_payment < 0) {
            $payment_status = 'Overpayment';
        }
        else {
            $payment_status = 'Partial';
        }

        $trx['paymentStatus'] = $payment_status;
        $trx['totalQuantity'] = $total_quantity;
        $trx['totalPrice'] = $total_price;
        $trx['grandTotal'] = $grand_total;
        $trx['remainingPayment'] = $remaining_payment;

        return $trx;
    }
}
