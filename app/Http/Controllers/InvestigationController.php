<?php

namespace App\Http\Controllers;

use App\Models\Investigation;
use App\Models\Department;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InvestigationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Investigation::with('department');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('department', function($row){
                    return $row->department ? $row->department->department : '';
                })
                ->addColumn('status', function($row){
                    $statusClass = $row->status === 'Active' ? 'success' : 'danger';
                    $newStatus = $row->status === 'Active' ? 'Inactive' : 'Active';
                    return '<button class="btn btn-'.$statusClass.' btn-xs toggleStatus" data-id="'.$row->id.'" data-status="'.$newStatus.'">'.$row->status.'</button>';
                })
                ->addColumn('action', function($row){
                    return '<button class="btn btn-primary btn-xs editBtn" data-id="'.$row->id.'"><i class="fas fa-edit"></i></button> '
                        .'<button class="btn btn-danger btn-xs deleteBtn" data-id="'.$row->id.'"><i class="fas fa-trash"></i></button>';
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }
        $departments = Department::where('status', 'Active')->get();
        return view('investigation.index', compact('departments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);
        $data['status'] = 'Active';
        Investigation::create($data);
        return response()->json(['success' => true, 'message' => 'Investigation created successfully.']);
    }

    public function show($id)
    {
        $investigation = Investigation::findOrFail($id);
        return response()->json($investigation);
    }

    public function update(Request $request, $id)
    {
        $investigation = Investigation::findOrFail($id);
        // If only status is being updated (toggle)
        if ($request->has('status') && count($request->all()) === 2) { // status + _token
            $investigation->update(['status' => $request->status]);
            return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
        }
        $data = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);
        $investigation->update($data);
        return response()->json(['success' => true, 'message' => 'Investigation updated successfully.']);
    }

    public function destroy($id)
    {
        $investigation = Investigation::findOrFail($id);
        $investigation->delete();
        return response()->json(['success' => true, 'message' => 'Investigation deleted successfully.']);
    }

    public function toggleStatus($id, Request $request)
    {
        $investigation = Investigation::findOrFail($id);
        $investigation->status = $request->status;
        $investigation->save();
        return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
    }
}
