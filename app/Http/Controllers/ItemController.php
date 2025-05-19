<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $items = Item::all();
        
        // Return JSON response for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'items' => $items
            ]);
        }
        
        // Regular view response
        return view('item_manage', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'item_code' => 'nullable|string|max:255|unique:items',
            'purchase_price' => 'required|numeric',
            'sales_price' => 'required|numeric',
            'unit' => 'required|string|max:50',
            'opening_stock' => 'required|integer|min:0',
        ]);

        $validated['current_stock'] = $validated['opening_stock'];

        $item = Item::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Item added successfully.',
            'item' => $item
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'item_code' => 'nullable|string|max:255|unique:items,item_code,' . $id,
            'purchase_price' => 'required|numeric',
            'sales_price' => 'required|numeric',
            'unit' => 'required|string|max:50',
            'opening_stock' => 'required|integer|min:0',
        ]);

        $item = Item::findOrFail($id);
        $item->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Item updated successfully.',
            'item' => $item
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
