<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Setting;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Permission;


class RoleController extends Controller 
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
            $data = Role::select('id', 'name as role_name')
            ->with('permissions:id,name')
            ->get();

            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex justify-content-center">';
                    $btn .= '<a href="' . route('role.edit', $row->id) . '" class="btn btn-warning btn-sm mx-1"><i class="fas fa-edit"></i></a>';
                    $btn .= '<a href="' . route('role.destroy', $row->id) . '" class="btn btn-danger btn-sm mx-1" onclick="event.preventDefault(); if(confirm(\'Are you sure?\')) { document.getElementById(\'delete-form-' . $row->id . '\').submit(); }"><i class="fas fa-trash"></i></a>';
                    $btn .= '<form id="delete-form-' . $row->id . '" action="' . route('role.destroy', $row->id) . '" method="POST" style="display: none;">' . csrf_field() . method_field('DELETE') . '</form>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);

        }

        $content = 'roles.index';
        return view('template', compact('content'));
    }


    public function create()
    {   
        $permissions = Permission::orderBy('name')->pluck('name','name');
        
        $content = 'roles.create';
        return view('template', compact('content','permissions'));
    }

    public function store(Request $request)
    {
         // validate request
         $request->validate([
            'name' => 'required|min:3|max:255|unique:roles',
            'selectedPermissions' => 'required|array|min:1',
        ]);

        // create new role data
        $role = Role::create(['name' => $request->name]);

        // give permissions to role
        $role->givePermissionTo($request->selectedPermissions);

        return redirect()->route('role.index')
                         ->with('success', 'Role updated successfully');
    }


    public function show(string $id)
    {
        //
    }


    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = Permission::orderBy('name')->pluck('name','name');
        $rolePermissions = $role->permissions->pluck('name','name')->all();

        $content = 'roles.edit';
        return view('template', compact('content', 'permissions', 'role','rolePermissions'));
    }


    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|min:3|max:255|unique:roles,name,'.$role->id,
            'selectedPermissions' => 'required|array|min:1',
        ]);

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->selectedPermissions);

        return redirect()->route('role.index')
                         ->with('success', 'Role updated successfully');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('role.index')
                        ->with('success','Role deleted successfully');
    }
}