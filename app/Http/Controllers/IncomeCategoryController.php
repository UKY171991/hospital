<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IncomeCategory;

class IncomeCategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = IncomeCategory::select('id', 'type', 'name', 'income_type')->get();
            return response()->json(['data' => $categories]);
        }

        return view('income_category.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'income_type' => 'required|string|max:255',
        ]);

        IncomeCategory::create($request->only('name', 'type', 'income_type'));

        return response()->json(['success' => true, 'message' => 'Category added successfully.']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = IncomeCategory::findOrFail($id);
        $category->update($request->only('name'));

        return response()->json(['success' => true, 'message' => 'Category updated successfully.']);
    }

    public function destroy($id)
    {
        $category = IncomeCategory::findOrFail($id);
        $category->delete();

        return response()->json(['success' => true, 'message' => 'Category deleted successfully.']);
    }
}
