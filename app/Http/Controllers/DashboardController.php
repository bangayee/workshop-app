<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;


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

    public function index()
    {
        
        $content = 'dashboard';
        return view('template', compact('content'));
    }


}
