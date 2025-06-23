<?php

namespace App\Http\Controllers;

use App\Models\AssignBed;
use App\Models\Bed;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AssignBedController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = AssignBed::with('bed');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('bed', function($row){
                    return $row->bed ? $row->bed->bed_number : '';
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
        $beds = Bed::where('status', 'Active')->get();
        return view('assign_bed.index', compact('beds'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'bed_id' => 'required|exists:beds,id',
            'patient_name' => 'required|string|max:255',
            'assign_date' => 'required|date',
            'release_date' => 'nullable|date',
        ]);
        $data['status'] = 'Active';
        AssignBed::create($data);
        return response()->json(['success' => true, 'message' => 'Bed assigned successfully.']);
    }

    public function show($id)
    {
        $assignBed = AssignBed::findOrFail($id);
        return response()->json($assignBed);
    }

    public function update(Request $request, $id)
    {
        $assignBed = AssignBed::findOrFail($id);
        // If only status is being updated (toggle)
        if ($request->has('status') && count($request->all()) === 2) { // status + _token
            $assignBed->update(['status' => $request->status]);
            return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
        }
        $data = $request->validate([
            'bed_id' => 'required|exists:beds,id',
            'patient_name' => 'required|string|max:255',
            'assign_date' => 'required|date',
            'release_date' => 'nullable|date',
        ]);
        $assignBed->update($data);
        return response()->json(['success' => true, 'message' => 'Bed assignment updated successfully.']);
    }

    public function destroy($id)
    {
        $assignBed = AssignBed::findOrFail($id);
        $assignBed->delete();
        return response()->json(['success' => true, 'message' => 'Bed assignment deleted successfully.']);
    }
}
