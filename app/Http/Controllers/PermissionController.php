<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Setting;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;


class PermissionController extends Controller
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
            $data = Permission::get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="' . route('permission.edit', $row->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a> ';
                    $btn .= '<a href="' . route('permission.destroy', $row->id) . '" class="btn btn-danger btn-sm" onclick="event.preventDefault(); if(confirm(\'Are you sure?\')) { document.getElementById(\'delete-form-' . $row->id . '\').submit(); }"><i class="fas fa-trash"></i></a>';
                    $btn .= '<form id="delete-form-' . $row->id . '" action="' . route('permission.destroy', $row->id) . '" method="POST" style="display: none;">' . csrf_field() . method_field('DELETE') . '</form>';
                    return $btn;
                })
                ->rawColumns(['action']) // Allow HTML rendering for these columns
                ->make(true);
        }

        $content = 'permissions.index';
        return view('template', compact('content'));
    }

    public function create()
    {
        $content = 'permissions.create';
        return view('template', compact('content'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'guard_name' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        $permission = new Permission();
        $permission->name = $request->name;
        $permission->guard_name = $request->guard_name;

    
        $permission->save();

        return redirect()->route('permission.index')->with('success', 'Permission created successfully.');
    }

    public function edit($id)
    {
        $permission = Permission::find($id);
        $content = 'permissions.edit';
        return view('template', compact('content','permission'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'guard_name' => 'required',
        ]);

        $permission = Permission::find($id);
        $permission->name = $request->name;
        $permission->guard_name = $request->guard_name;

        $permission->save();

        return redirect()->route('permission.index')->with('success', 'Permission updated successfully.');
    }

    public function destroy($id)
    {
        Permission::find($id)->delete();
        return redirect()->route('permission.index')
                        ->with('success','Permission deleted successfully');
    }
    

}
