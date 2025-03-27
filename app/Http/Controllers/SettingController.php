<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;


class SettingController extends Controller 
{
    public $settings;

    public function __construct()
    {
        $this->settings = Setting::all();

        foreach ($this->settings as $setting) {
            $this->{$setting->setting_name} = $setting->value;
            View::share($setting->setting_name, $setting->value); // Share each setting globally
        }
        // echo $this->site_name; exit;
        // public $setting ;
        // echo $this->site_name; exit;
    }
    
    public function index()
    {
        // dd(Auth::user()->roles[0]->name);
        // echo $this->site_name; exit;
        $settings = Setting::all();

        // dd($settings);
        
        $content = 'settings.index';
        return view('template', compact('content','settings'));
        
    }

    public function update(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'settings[]' => 'required'
        // ]);

        // if ($validator->fails()) {
        //     return redirect()->back()
        //                     ->withErrors($validator)
        //                     ->withInput();
        // }

        $settings = Setting::all();
    
        $a=0;$b=0;
        foreach ($settings as $index => $setting) {
            // Check if the setting is an image
            
            if ($setting->type == 'image' && $request->hasFile('setting_image.' . $setting->setting_name)) {
                // Handle file upload
                $file = $request->file('setting_image.' . $setting->setting_name);
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('storage/uploads/setting_file'), $fileName);
    
                // Update the setting value with the file name
                $setting->value = $fileName;
                $a++;
            } else {
                // Update the setting value for text inputs
                if($setting->type != 'image'){
                    if($request->input('setting.' . $setting->setting_name) != null)
                    {
                        $setting->value = $request->input('setting.' . $setting->setting_name);
                    }
                    else
                    {
                        return redirect()->back()
                            ->withErrors("Please fill all the fields")
                            ->withInput();
                    }
                    
                } 
               
            }

            
    
            // Save the updated setting
            $setting->save();
        }
        // echo $a.""." -- ".$b;
        //     exit;
    
        return redirect()->route('setting.index')->with('success', 'Settings updated successfully.');
    }

}