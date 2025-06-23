<?php

namespace App\Http\Controllers;

use App\Models\Bed;
use App\Models\Room;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BedController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Bed::with('room');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('room', function($row){
                    return $row->room ? $row->room->name : '';
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
        $rooms = Room::where('status', 'Active')->get();
        return view('bed.index', compact('rooms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'bed_number' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);
        $data['status'] = 'Active';
        Bed::create($data);
        return response()->json(['success' => true, 'message' => 'Bed created successfully.']);
    }

    public function show($id)
    {
        $bed = Bed::findOrFail($id);
        return response()->json($bed);
    }

    public function update(Request $request, $id)
    {
        $bed = Bed::findOrFail($id);
        // If only status is being updated (toggle)
        if ($request->has('status') && count($request->all()) === 2) { // status + _token
            $bed->update(['status' => $request->status]);
            return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
        }
        $data = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'bed_number' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);
        $bed->update($data);
        return response()->json(['success' => true, 'message' => 'Bed updated successfully.']);
    }

    public function destroy($id)
    {
        $bed = Bed::findOrFail($id);
        $bed->delete();
        return response()->json(['success' => true, 'message' => 'Bed deleted successfully.']);
    }
}
