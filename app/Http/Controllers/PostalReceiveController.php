<?php

namespace App\Http\Controllers;

use App\Models\PostalReceive;
use Illuminate\Http\Request;

class PostalReceiveController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PostalReceive::all();
            return response()->json(['data' => $data]);
        }
        return view('postal_receive.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $postalReceive = PostalReceive::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => 1,
        ]);
        return response()->json(['success' => true, 'data' => $postalReceive]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $postalReceive = PostalReceive::findOrFail($id);
        $postalReceive->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return response()->json(['success' => true, 'data' => $postalReceive]);
    }

    public function destroy($id)
    {
        $postalReceive = PostalReceive::findOrFail($id);
        $postalReceive->delete();
        return response()->json(['success' => true]);
    }

    public function toggleStatus($id)
    {
        $postalReceive = PostalReceive::findOrFail($id);
        $postalReceive->status = !$postalReceive->status;
        $postalReceive->save();
        return response()->json(['success' => true, 'status' => $postalReceive->status]);
    }
} 