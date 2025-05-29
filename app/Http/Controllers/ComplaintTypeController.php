<?php

namespace App\Http\Controllers;

use App\Models\ComplaintType;
use Illuminate\Http\Request;

class ComplaintTypeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ComplaintType::all();
            return response()->json(['data' => $data]);
        }
        return view('complaint_type.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $complaintType = ComplaintType::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => 1,
        ]);
        return response()->json(['success' => true, 'data' => $complaintType]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $complaintType = ComplaintType::findOrFail($id);
        $complaintType->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return response()->json(['success' => true, 'data' => $complaintType]);
    }

    public function destroy($id)
    {
        $complaintType = ComplaintType::findOrFail($id);
        $complaintType->delete();
        return response()->json(['success' => true]);
    }

    public function toggleStatus($id)
    {
        $complaintType = ComplaintType::findOrFail($id);
        $complaintType->status = !$complaintType->status;
        $complaintType->save();
        return response()->json(['success' => true, 'status' => $complaintType->status]);
    }
} 