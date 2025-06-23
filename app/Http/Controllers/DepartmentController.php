<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Department::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    $icon = $row->status === 'Active' ? 'fa-eye text-success' : 'fa-eye-slash text-warning';
                    $nextStatus = $row->status === 'Active' ? 'Inactive' : 'Active';
                    return '<a href="#" class="toggleStatus" data-id="'.$row->id.'" data-status="'.$nextStatus.'"><i class="fas '.$icon.'"></i></a>';
                })
                ->addColumn('action', function($row){
                    return '<button class="btn btn-primary btn-xs editBtn" data-id="'.$row->id.'"><i class="fas fa-edit"></i></button> '
                        .'<button class="btn btn-danger btn-xs deleteBtn" data-id="'.$row->id.'"><i class="fas fa-trash"></i></button>';
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
        if ($request->has('status') && count($request->all()) <= 3) { // status + _token + _method
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

    public function toggleStatus($id, Request $request)
    {
        $department = Department::findOrFail($id);
        $department->status = $request->status;
        $department->save();
        return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
    }

    // Test endpoint to debug DataTable
    public function testDataTable()
    {
        $departments = Department::all();
        
        // Debug information
        $debug = [
            'count' => $departments->count(),
            'departments' => $departments->toArray(),
            'request_headers' => request()->headers->all(),
            'is_ajax' => request()->ajax(),
            'method' => request()->method(),
        ];
        
        return response()->json($debug);
    }
    
    // Debug endpoint for manual testing
    public function debug()
    {
        $departments = Department::all();
        return response()->json([
            'success' => true,
            'count' => $departments->count(),
            'data' => $departments
        ]);
    }
}
