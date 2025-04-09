<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Setting;
use App\Models\Workflow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;


class WorkflowController extends Controller
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
        // $data = Workflow::get();
        // dd($data);
        if ($request->ajax()) {
            $data = Workflow::orderBy('order')->get();

            return Datatables::of($data)
                ->addColumn('status', function ($row) {
                    return '<label class="badge bg-'.$row->color.'">'. $row->name.'</label>'; 
                })
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex justify-content-center">';
                    $btn .= '<a href="' . route('workflow.edit', $row->id) . '" class="btn btn-warning btn-sm mx-1"><i class="fas fa-edit"></i></a>';
                    if($row->status != 'order' and $row->status != 'done'){
                        $btn .= '<a href="' . route('workflow.destroy', $row->id) . '" class="btn btn-danger btn-sm mx-1" onclick="event.preventDefault(); if(confirm(\'Are you sure?\')) { document.getElementById(\'delete-form-' . $row->id . '\').submit(); }"><i class="fas fa-trash"></i></a>';
                        $btn .= '<form id="delete-form-' . $row->id . '" action="' . route('workflow.destroy', $row->id) . '" method="POST" style="display: none;">' . csrf_field() . method_field('DELETE') . '</form>';
                    }
                    $btn .= '</div>';
                    
                    return $btn;
                })
                ->rawColumns(['status','action']) // Allow HTML rendering for these columns
                ->make(true);
        }

        $content = 'workflows.index';
        return view('template', compact('content'));
    }

    public function create()
    {
        $content = 'workflows.create';
        return view('template', compact('content'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'order' => 'required',
            'color' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        $workflow = new Workflow();
        $workflow->name = $request->name;
        $workflow->order = $request->order;
        $workflow->color = $request->color;
        $workflow->save();

        return redirect()->route('workflow.index')->with('success', 'Workflow created successfully.');
    }

    public function edit($id)
    {
        $workflow = Workflow::find($id);
        $content = 'workflows.edit';
        return view('template', compact('content','workflow'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'order' => 'required',
            'color' => 'required',
        ]);

        $workflow = Workflow::find($id);
        $workflow->name = $request->name;
        $workflow->order = $request->order;
        $workflow->color = $request->color;
        $workflow->save();

        return redirect()->route('workflow.index')->with('success', 'Workflow updated successfully.');
    }

    public function destroy($id)
    {
        Workflow::find($id)->delete();
        return redirect()->route('workflow.index')
                        ->with('success','Workflow deleted successfully');
    }
    

}
