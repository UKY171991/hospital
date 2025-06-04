<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IncomeItem;

class IncomeItemController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = IncomeItem::all();
            $data = $items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'type' => $item->type,
                    'price' => $item->price,
                    'unit' => $item->unit,
                ];
            });
            return response()->json(['data' => $data]);
        }
        return view('income_item.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'unit' => 'required|string|max:255',
        ]);

        IncomeItem::create($validated);
        return response()->json(['message' => 'Item created successfully']);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'unit' => 'required|string|max:255',
        ]);

        $item = IncomeItem::findOrFail($id);
        $item->update($validated);
        return response()->json(['message' => 'Item updated successfully']);
    }

    public function destroy($id)
    {
        $item = IncomeItem::findOrFail($id);
        $item->delete();
        return response()->json(['message' => 'Item deleted successfully']);
    }
}
