<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Setting;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Models\TransactionDetailProductSupplier;


class DashboardController extends Controller
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

    public function indexx()
    {
        // get total transactions
        $data['total_order'] = Transaction::count();
        $data['remaining_order'] = Transaction::where('order_status','<>','6')->count();
        $data['total_product'] = Transaction::sum('total_quantity');
        $data['remaining_product'] = Transaction::where('order_status','<>','6')->sum('total_quantity');
        $data['total_customer'] = Transaction::distinct('customer_id')->count('customer_id');
        
        $data['total_cities'] = Customer::whereHas('transactions') 
        ->whereNotNull('city') 
        ->distinct('city') 
        ->count('city');

        $grand_total = Transaction::sum('grand_total');
        $data['total_sales'] = number_format($grand_total, 0, ',', '.');

        $remaining_payment = Transaction::sum('remaining_balance');
        $data['remaining_payment'] = number_format($remaining_payment, 0, ',', '.');


        // dd($data);
        // exit;

        $content = 'dashboard';
        return view('template', compact('content','data'));
    }

    public function index()
    {
            // Count transactions grouped by month
    $monthlyTransactions = Transaction::select(
        DB::raw('EXTRACT(MONTH FROM order_date) as month'),
        DB::raw('COUNT(*) AS count'),
        DB::raw('SUM(total_quantity) AS total_products')
    )
    ->groupBy('month')
    ->orderBy('month')
    ->get();

    // Count transactions grouped by week
    $weeklyTransactions = Transaction::select(
        DB::raw('DATE_PART(\'week\', order_date) AS week'),
        DB::raw('COUNT(*) as count')
    )
    ->groupBy('week')
    ->orderBy('week')
    ->get();

    $data['monthlyTransactions'] = $monthlyTransactions;
    $data['weeklyTransactions'] = $weeklyTransactions;

    // Get daily transactions for the past 7 days
    $dailyTransactions = Transaction::select(
        DB::raw('DATE(order_date) as date'),
        DB::raw('COUNT(*) as count'),
        DB::raw('SUM(total_quantity) as total_products') // Add total products
    )
    ->where('order_date', '>=', Carbon::now()->subDays(7)) // Only fetch the last 7 days
    ->groupBy('date')
    ->orderBy('date')
    ->get();

    $data['dailyTransactions'] = $dailyTransactions;

    $orderStatusData = Transaction::join('workflows', 'transactions.order_status', '=', 'workflows.id')
        ->select(
            'workflows.name as workflow_name',
            DB::raw('COUNT(transactions.id) as count')
        )
        ->where('transactions.order_status', '<>', '6') 
        ->groupBy('workflows.name')
        ->get();
    $data['orderStatusData'] = $orderStatusData;

    // Other data for the dashboard
    $data['total_order'] = Transaction::count();
    $data['remaining_order'] = Transaction::where('order_status', '<>', '6')->count();
    $data['total_product'] = Transaction::sum('total_quantity');
    $data['remaining_product'] = Transaction::where('order_status', '<>', '6')->sum('total_quantity');
    $data['total_customer'] = Transaction::distinct('customer_id')->count('customer_id');
    $data['total_cities'] = Customer::whereHas('transactions')->whereNotNull('city')->distinct('city')->count('city');
    $total_sales = Transaction::sum('grand_total');
    $data['total_sales'] = number_format($total_sales, 0, ',', '.');
    $remaining_payment = Transaction::sum('remaining_balance');
    $data['remaining_payment'] = number_format($remaining_payment, 0, ',', '.');

    // Old transaction data
    // $oldTransactions = Transaction::where('order_date', '<', Carbon::now()->subDays($this->time_limit_for_orders))->get();
    // $data['oldTransactions'] = $oldTransactions;
    $data['oldTransactions'] = Transaction::where('order_date', '<', Carbon::now()->subDays($this->time_limit_for_orders))->with(['customer', 'workflow'])
        ->orderBy('order_date', 'desc')
        ->paginate(10); // Paginate with 10 items per page

    // dd($oldTransactions);
    // exit;
    $data['order_in_suppliers'] = TransactionDetailProductSupplier::select(
        'supplier_id',
        DB::raw('COUNT(*) as count')
    )
    ->where('process_status', '<>', '6')
    ->groupBy('supplier_id')
    ->get();

    // dd($data['order_in_suppliers']);
    // exit;
    
        $content = 'dashboard';
        return view('template', compact('content','data'));
    }


}
