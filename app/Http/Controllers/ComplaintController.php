<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Complaint::all();
            return response()->json(['data' => $data]);
        }
        return view('complaint.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $complaint = Complaint::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => 1,
        ]);
        return response()->json(['success' => true, 'data' => $complaint]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $complaint = Complaint::findOrFail($id);
        $complaint->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return response()->json(['success' => true, 'data' => $complaint]);
    }

    public function destroy($id)
    {
        $complaint = Complaint::findOrFail($id);
        $complaint->delete();
        return response()->json(['success' => true]);
    }

    public function toggleStatus($id)
    {
        $complaint = Complaint::findOrFail($id);
        $complaint->status = !$complaint->status;
        $complaint->save();
        return response()->json(['success' => true, 'status' => $complaint->status]);
    }
} 