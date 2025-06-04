<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Enquiry::all();
            return response()->json(['data' => $data]);
        }
        return view('enquiry.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $enquiry = Enquiry::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => 1,
        ]);
        return response()->json(['success' => true, 'data' => $enquiry]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $enquiry = Enquiry::findOrFail($id);
        $enquiry->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return response()->json(['success' => true, 'data' => $enquiry]);
    }

    public function destroy($id)
    {
        $enquiry = Enquiry::findOrFail($id);
        $enquiry->delete();
        return response()->json(['success' => true]);
    }

    public function toggleStatus($id)
    {
        $enquiry = Enquiry::findOrFail($id);
        $enquiry->status = !$enquiry->status;
        $enquiry->save();
        return response()->json(['success' => true, 'status' => $enquiry->status]);
    }
} 