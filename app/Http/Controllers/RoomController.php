<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Ward;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Room::with('ward');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('ward', function($row){
                    return $row->ward ? $row->ward->name : '';
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
        $wards = Ward::where('status', 'Active')->get();
        return view('room.index', compact('wards'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ward_id' => 'required|exists:wards,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);
        $data['status'] = 'Active';
        Room::create($data);
        return response()->json(['success' => true, 'message' => 'Room created successfully.']);
    }

    public function show($id)
    {
        $room = Room::findOrFail($id);
        return response()->json($room);
    }

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        // If only status is being updated (toggle)
        if ($request->has('status') && count($request->all()) === 2) { // status + _token
            $room->update(['status' => $request->status]);
            return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
        }
        $data = $request->validate([
            'ward_id' => 'required|exists:wards,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);
        $room->update($data);
        return response()->json(['success' => true, 'message' => 'Room updated successfully.']);
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();
        return response()->json(['success' => true, 'message' => 'Room deleted successfully.']);
    }
}
