<?php

namespace App\Http\Controllers;

use App\Models\Disease;
use App\Models\Department;
use Illuminate\Http\Request;
use DataTables;

class DiseaseController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Disease::with('department');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('department', function($row){
                    return $row->department ? $row->department->department : '';
                })
                ->addColumn('status', function($row){
                    $icon = $row->status === 'Active' ? 'fa-eye text-success' : 'fa-eye-slash text-warning';
                    $nextStatus = $row->status === 'Active' ? 'Inactive' : 'Active';
                    return '<a href="#" class="toggleStatus" data-id="'.$row->id.'" data-status="'.$nextStatus.'"><i class="fas '.$icon.'"></i></a>';
                })
                ->addColumn('action', function($row){
                    return '<button class="btn btn-primary btn-xs editBtn" data-id="'.$row->id.'"><i class="fas fa-edit"></i></button>';
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }
        $departments = Department::where('status', 'Active')->get();
        return view('disease.index', compact('departments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'disease' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);
        $data['status'] = 'Active';
        Disease::create($data);
        return response()->json(['success' => true, 'message' => 'Disease created successfully.']);
    }

    public function show($id)
    {
        $disease = Disease::findOrFail($id);
        return response()->json($disease);
    }

    public function update(Request $request, $id)
    {
        $disease = Disease::findOrFail($id);
        // If only status is being updated (toggle)
        if ($request->has('status') && count($request->all()) === 2) { // status + _token
            $disease->update(['status' => $request->status]);
            return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
        }
        $data = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'disease' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);
        $disease->update($data);
        return response()->json(['success' => true, 'message' => 'Disease updated successfully.']);
    }

    public function destroy($id)
    {
        $disease = Disease::findOrFail($id);
        $disease->delete();
        return response()->json(['success' => true, 'message' => 'Disease deleted successfully.']);
    }
}
