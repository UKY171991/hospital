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
            
            // Add debugging
            \Log::info('Department DataTable Request:', [
                'ajax' => $request->ajax(),
                'headers' => $request->headers->all(),
                'query' => $request->query->all(),
                'count' => $data->count()
            ]);
            
            $result = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    $statusClass = $row->status === 'Active' ? 'success' : 'danger';
                    $newStatus = $row->status === 'Active' ? 'Inactive' : 'Active';
                    return '<button class="btn btn-'.$statusClass.' btn-xs toggleStatus" data-id="'.$row->id.'" data-status="'.$newStatus.'">'.$row->status.'</button>';
                })
                ->addColumn('action', function($row){
                    return '<div class="btn-group" role="group">'
                        .'<button type="button" class="btn btn-sm btn-info editBtn" data-id="'.$row->id.'" title="Edit">'
                        .'<i class="fas fa-edit"></i></button>'
                        .'<button type="button" class="btn btn-sm btn-danger deleteBtn" data-id="'.$row->id.'" title="Delete">'
                        .'<i class="fas fa-trash"></i></button>'
                        .'</div>';
                })
                ->rawColumns(['status','action'])
                ->make(true);
            
            \Log::info('DataTable Response:', ['response' => $result->getData()]);
            
            return $result;
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
        return response()->json([
            'success' => true,
            'count' => $departments->count(),
            'data' => $departments
        ]);
    }
}
