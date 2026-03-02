<?php

namespace App\Http\Controllers;

use App\Models\PathologyMainTestCategory;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PathologyMainTestCategoryController extends Controller
{
    public function index()
    {
        return view('pathology.main_test_categories');
    }

    public function data(): JsonResponse
    {
        try {
            $categories = PathologyMainTestCategory::select('id', 'name', 'description')
                ->latest('id')
                ->get();
        } catch (QueryException $exception) {
            if ($this->isMissingTableException($exception)) {
                return response()->json([
                    'data' => [],
                    'warning' => 'Pathology main test category table is missing. Run migrations to enable this module.',
                ]);
            }

            throw $exception;
        }

        return response()->json(['data' => $categories]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        try {
            PathologyMainTestCategory::create($validated);
        } catch (QueryException $exception) {
            if ($this->isMissingTableException($exception)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Main test categories are not available yet. Please run migrations first.',
                ], 503);
            }

            throw $exception;
        }

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

        try {
            $category = PathologyMainTestCategory::findOrFail($id);
            $category->update($validated);
        } catch (QueryException $exception) {
            if ($this->isMissingTableException($exception)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Main test categories are not available yet. Please run migrations first.',
                ], 503);
            }

            throw $exception;
        }

        return response()->json([
            'success' => true,
            'message' => 'Main test category updated successfully.',
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $category = PathologyMainTestCategory::findOrFail($id);
            $category->delete();
        } catch (QueryException $exception) {
            if ($this->isMissingTableException($exception)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Main test categories are not available yet. Please run migrations first.',
                ], 503);
            }

            throw $exception;
        }

        return response()->json([
            'success' => true,
            'message' => 'Main test category deleted successfully.',
        ]);
    }

    private function isMissingTableException(QueryException $exception): bool
    {
        return (int) ($exception->errorInfo[1] ?? 0) === 1146;
    }
}
