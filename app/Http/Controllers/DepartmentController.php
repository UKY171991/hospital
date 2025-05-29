<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use DataTables;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Department::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    return $row->status;
                })
                ->addColumn('action', function($row){
                    return '<button class="btn btn-primary btn-xs editBtn" data-id="'.$row->id.'"><i class="fas fa-edit"></i></button>';
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }
        return view('department.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'department' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);
        $data['status'] = 'Active';
        Department::create($data);
        return response()->json(['success' => true, 'message' => 'Department created successfully.']);
    }

    public function show($id)
    {
        $department = Department::findOrFail($id);
        return response()->json($department);
    }

    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);
        // If only status is being updated (toggle)
        if ($request->has('status') && count($request->all()) === 2) { // status + _token
            $department->update(['status' => $request->status]);
            return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
        }
        $data = $request->validate([
            'department' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);
        $department->update($data);
        return response()->json(['success' => true, 'message' => 'Department updated successfully.']);
    }

    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        return response()->json(['success' => true, 'message' => 'Department deleted successfully.']);
    }
}
