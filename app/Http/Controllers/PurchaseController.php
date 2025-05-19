<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase; // Add this line

class PurchaseController extends Controller
{
    //
    public function store(Request $request)
    {
        \Log::info('Purchase Store Request:', $request->all());

        $validated = $request->validate([
            'invoice_no' => 'required|unique:purchases',
            'date' => 'required|date',
            'supplier_name' => 'required|string',
            'purchase_order_no' => 'nullable|string',
            'eway_bill_no' => 'nullable|string',
            'total_amount' => 'required|numeric',
            'remarks' => 'nullable|string',
            'purchase_items' => 'required|array', // Changed from 'items' to 'purchase_items'
            'purchase_items.*.item_id' => 'required|exists:items,id', // Changed from 'items.*.item_id'
            'purchase_items.*.price' => 'required|numeric', // Changed from 'items.*.price'
            'purchase_items.*.quantity' => 'required|integer', // Changed from 'items.*.quantity'
            'purchase_items.*.amount' => 'required|numeric', // Changed from 'items.*.amount'
        ]);

        $purchase = Purchase::create($validated);
        foreach ($validated['purchase_items'] as $item) { // Changed from 'items' to 'purchase_items'
            $purchase->items()->create($item);
        }

        return response()->json(['success' => true, 'message' => 'Purchase added successfully.']);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'invoice_no' => 'required|unique:purchases,invoice_no,' . $id,
            'date' => 'required|date',
            'supplier_name' => 'required|string',
            'purchase_order_no' => 'nullable|string',
            'eway_bill_no' => 'nullable|string',
            'total_amount' => 'required|numeric',
            'remarks' => 'nullable|string',
            'purchase_items' => 'required|array', // Changed from 'items' to 'purchase_items'
            'purchase_items.*.item_id' => 'required|exists:items,id', // Changed from 'items.*.item_id'
            'purchase_items.*.price' => 'required|numeric', // Changed from 'items.*.price'
            'purchase_items.*.quantity' => 'required|integer', // Changed from 'items.*.quantity'
            'purchase_items.*.amount' => 'required|numeric', // Changed from 'items.*.amount'
        ]);

        $purchase = Purchase::findOrFail($id);
        $purchase->update($validated);
        $purchase->items()->delete();
        foreach ($validated['purchase_items'] as $item) { // Changed from 'items' to 'purchase_items'
            $purchase->items()->create($item);
        }

        return response()->json(['success' => true, 'message' => 'Purchase updated successfully.']);
    }

    public function destroy($id)
    {
        $purchase = Purchase::findOrFail($id);
        $purchase->delete();

        return response()->json(['success' => true, 'message' => 'Purchase deleted successfully.']);
    }
}
