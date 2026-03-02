<?php

namespace App\Http\Controllers;

use App\Models\PathologyMainTestCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PathologyMainTestCategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = PathologyMainTestCategory::select('id', 'name', 'description')
                ->latest('id')
                ->get();

            return response()->json(['data' => $categories]);
        }

        return view('pathology.main_test_categories');
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        PathologyMainTestCategory::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Main test category created successfully.',
        ]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $category = PathologyMainTestCategory::findOrFail($id);
        $category->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Main test category updated successfully.',
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $category = PathologyMainTestCategory::findOrFail($id);
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Main test category deleted successfully.',
        ]);
    }
}
