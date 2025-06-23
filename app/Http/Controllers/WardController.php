<?php

namespace App\Http\Controllers;

use App\Models\Ward;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class WardController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Ward::query();
            return DataTables::of($data)
                ->addIndexColumn()
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
        return view('ward.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);
        $data['status'] = 'Active';
        Ward::create($data);
        return response()->json(['success' => true, 'message' => 'Ward created successfully.']);
    }

    public function show($id)
    {
        $ward = Ward::findOrFail($id);
        return response()->json($ward);
    }

    public function update(Request $request, $id)
    {
        $ward = Ward::findOrFail($id);
        // If only status is being updated (toggle)
        if ($request->has('status') && count($request->all()) === 2) { // status + _token
            $ward->update(['status' => $request->status]);
            return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
        }
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);
        $ward->update($data);
        return response()->json(['success' => true, 'message' => 'Ward updated successfully.']);
    }

    public function destroy($id)
    {
        $ward = Ward::findOrFail($id);
        $ward->delete();
        return response()->json(['success' => true, 'message' => 'Ward deleted successfully.']);
    }

    public function toggleStatus($id, Request $request)
    {
        $ward = Ward::findOrFail($id);
        $ward->status = $request->status;
        $ward->save();
        return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
    }
}
