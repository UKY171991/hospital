<?php

namespace App\Http\Controllers;

use App\Models\IncomeExpense;
use App\Models\IncomeCategory;
use App\Models\IncomeItem;
use Illuminate\Http\Request;

class IncomeExpenseController extends Controller
{
    // Show the page or return JSON for DataTable
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = IncomeExpense::with(['item']);
            $data = $query->get()->map(function ($entry) {
                return [
                    'id' => $entry->id,
                    'date' => $entry->date,
                    'type' => $entry->type,
                    'category' => $entry->category,
                    'item_id' => $entry->item_id,
                    'item_name' => $entry->item ? $entry->item->name : '',
                    'amount' => $entry->amount,
                    'description' => $entry->description,
                    'action' => '<button class="btn btn-info btn-sm editBtn" data-id="'.$entry->id.'"><i class="fa fa-edit"></i></button> <button class="btn btn-danger btn-sm deleteBtn" data-id="'.$entry->id.'"><i class="fa fa-trash"></i></button>',
                ];
            });
            return response()->json(['data' => $data]);
        }
        return view('income_expense.index');
    }

    // Store new entry
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'type' => 'required|in:Income,Expenses',
            'category' => 'required|string',
            'item_id' => 'required|exists:income_items,id',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
        ]);
        $entry = IncomeExpense::create($request->only('date', 'type', 'category', 'item_id', 'amount', 'description'));
        return response()->json(['success' => true, 'data' => $entry]);
    }

    // Update entry
    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'type' => 'required|in:Income,Expenses',
            'category' => 'required|string',
            'item_id' => 'required|exists:income_items,id',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
        ]);
        $entry = IncomeExpense::findOrFail($id);
        $entry->update($request->only('date', 'type', 'category', 'item_id', 'amount', 'description'));
        return response()->json(['success' => true, 'data' => $entry]);
    }

    // Delete entry
    public function destroy($id)
    {
        $entry = IncomeExpense::findOrFail($id);
        $entry->delete();
        return response()->json(['success' => true]);
    }

    // Show single entry for edit
    public function show($id)
    {
        $entry = IncomeExpense::findOrFail($id);
        return response()->json($entry);
    }
} 