<?php

namespace App\Http\Controllers;

use App\Models\Reference;
use Illuminate\Http\Request;

class ReferenceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Reference::all();
            return response()->json(['data' => $data]);
        }
        return view('reference.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $reference = Reference::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => 1,
        ]);
        return response()->json(['success' => true, 'data' => $reference]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $reference = Reference::findOrFail($id);
        $reference->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return response()->json(['success' => true, 'data' => $reference]);
    }

    public function destroy($id)
    {
        $reference = Reference::findOrFail($id);
        $reference->delete();
        return response()->json(['success' => true]);
    }

    public function toggleStatus($id)
    {
        $reference = Reference::findOrFail($id);
        $reference->status = !$reference->status;
        $reference->save();
        return response()->json(['success' => true, 'status' => $reference->status]);
    }
} 