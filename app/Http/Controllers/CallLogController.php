<?php

namespace App\Http\Controllers;

use App\Models\CallLog;
use Illuminate\Http\Request;

class CallLogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CallLog::all();
            return response()->json(['data' => $data]);
        }
        return view('call_log.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $callLog = CallLog::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => 1,
        ]);
        return response()->json(['success' => true, 'data' => $callLog]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $callLog = CallLog::findOrFail($id);
        $callLog->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return response()->json(['success' => true, 'data' => $callLog]);
    }

    public function destroy($id)
    {
        $callLog = CallLog::findOrFail($id);
        $callLog->delete();
        return response()->json(['success' => true]);
    }

    public function toggleStatus($id)
    {
        $callLog = CallLog::findOrFail($id);
        $callLog->status = !$callLog->status;
        $callLog->save();
        return response()->json(['success' => true, 'status' => $callLog->status]);
    }
} 