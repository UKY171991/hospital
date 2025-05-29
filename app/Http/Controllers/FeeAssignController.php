<?php

namespace App\Http\Controllers;

use App\Models\FeeAssign;
use App\Models\Department;
use Illuminate\Http\Request;
use DataTables;

class FeeAssignController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = FeeAssign::with('department');
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
                    return '<button class="btn btn-primary btn-xs editBtn" data-id="'.$row->id.'"><i class="fas fa-edit"></i></button> '
                        .'<button class="btn btn-danger btn-xs deleteBtn" data-id="'.$row->id.'"><i class="fas fa-trash"></i></button>';
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }
        $departments = Department::where('status', 'Active')->get();
        return view('fee_assign.index', compact('departments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'item_name' => 'required|string|max:255',
            'amount' => 'required|numeric',
        ]);
        $data['status'] = 'Active';
        FeeAssign::create($data);
        return response()->json(['success' => true, 'message' => 'Fee assigned successfully.']);
    }

    public function show($id)
    {
        $feeAssign = FeeAssign::findOrFail($id);
        return response()->json($feeAssign);
    }

    public function update(Request $request, $id)
    {
        $feeAssign = FeeAssign::findOrFail($id);
        // If only status is being updated (toggle)
        if ($request->has('status') && count($request->all()) === 2) { // status + _token
            $feeAssign->update(['status' => $request->status]);
            return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
        }
        $data = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'item_name' => 'required|string|max:255',
            'amount' => 'required|numeric',
        ]);
        $feeAssign->update($data);
        return response()->json(['success' => true, 'message' => 'Fee assignment updated successfully.']);
    }

    public function destroy($id)
    {
        $feeAssign = FeeAssign::findOrFail($id);
        $feeAssign->delete();
        return response()->json(['success' => true, 'message' => 'Fee assignment deleted successfully.']);
    }
}
