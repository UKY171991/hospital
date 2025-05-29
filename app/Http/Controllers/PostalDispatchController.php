<?php

namespace App\Http\Controllers;

use App\Models\PostalDispatch;
use Illuminate\Http\Request;

class PostalDispatchController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PostalDispatch::all();
            return response()->json(['data' => $data]);
        }
        return view('postal_dispatch.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $postalDispatch = PostalDispatch::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => 1,
        ]);
        return response()->json(['success' => true, 'data' => $postalDispatch]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $postalDispatch = PostalDispatch::findOrFail($id);
        $postalDispatch->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return response()->json(['success' => true, 'data' => $postalDispatch]);
    }

    public function destroy($id)
    {
        $postalDispatch = PostalDispatch::findOrFail($id);
        $postalDispatch->delete();
        return response()->json(['success' => true]);
    }

    public function toggleStatus($id)
    {
        $postalDispatch = PostalDispatch::findOrFail($id);
        $postalDispatch->status = !$postalDispatch->status;
        $postalDispatch->save();
        return response()->json(['success' => true, 'status' => $postalDispatch->status]);
    }
} 