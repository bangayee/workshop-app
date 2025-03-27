<?php
    
namespace App\Http\Controllers;
    
use DB;
use Hash;
use DataTables;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;

    
class UserController extends Controller
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
            $data = User::join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                    ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->select('users.*', 'roles.name as role_name')
                    ->get();

                return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="' . route('user.show', $row->id) . '" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a> ';
                    $btn .= '<a href="' . route('user.edit', $row->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a> ';
                    $btn .= '<a href="' . route('user.destroy', $row->id) . '" class="btn btn-danger btn-sm" onclick="event.preventDefault(); if(confirm(\'Are you sure?\')) { document.getElementById(\'delete-form-' . $row->id . '\').submit(); }"><i class="fas fa-trash"></i></a>';
                    $btn .= '<form id="delete-form-' . $row->id . '" action="' . route('user.destroy', $row->id) . '" method="POST" style="display: none;">' . csrf_field() . method_field('DELETE') . '</form>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
       

       
        $content = 'users.index';
        return view('template', compact('content'));
    }

    public function create()
    {
        $roles = Role::all();
        $content = 'users.create';
        return view('template',compact('roles','content'));
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
    
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('user.index')
                         ->with('success', 'User created successfully');
    }
    
    public function show($id)
    {
        $user = User::find($id);
        $content = 'users.show';
        $role =  $user->roles->pluck('name')->all();

        return view('template',compact('user','content','role'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
    
        $content = 'users/edit';

        return view('template',compact('user','roles','userRole','content'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles' => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }
    
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, ['password']);
        }
    
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
    
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('user.index')
                         ->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('user.index')
                        ->with('success','User deleted successfully');
    }
}
