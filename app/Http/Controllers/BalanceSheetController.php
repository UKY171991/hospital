<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BalanceSheet;
use Yajra\DataTables\DataTables;

class BalanceSheetController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $balanceSheets = BalanceSheet::query();
            return DataTables::of($balanceSheets)
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-sm btn-primary editBtn" data-id="'.$row->id.'">Edit</button> <button class="btn btn-sm btn-danger deleteBtn" data-id="'.$row->id.'">Delete</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('reports.balance-sheet');
    }

    // Duplicate store method removed

    public function edit($id)
    {
        $entry = BalanceSheet::findOrFail($id);
        return response()->json($entry);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'report_type' => 'required|string|max:255',
            'month_year' => 'required|string|max:255',
            'credit' => 'required|numeric',
            'debit' => 'required|numeric',
            'balance' => 'required|numeric',
        ]);
        $entry = BalanceSheet::findOrFail($id);
        $entry->update($validatedData);
        return response()->json(['message' => 'Balance sheet entry updated successfully.']);
    }

    public function destroy($id)
    {
        $entry = BalanceSheet::findOrFail($id);
        $entry->delete();
        return response()->json(['message' => 'Balance sheet entry deleted successfully.']);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'report_type' => 'required|string|max:255',
            'month_year' => 'required|string|max:255',
            'credit' => 'required|numeric',
            'debit' => 'required|numeric',
            'balance' => 'required|numeric',
        ]);

        try {
            BalanceSheet::create($validatedData);
            return response()->json(['message' => 'Balance sheet entry saved successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to save balance sheet entry.', 'error' => $e->getMessage()], 500);
        }
    }
}
