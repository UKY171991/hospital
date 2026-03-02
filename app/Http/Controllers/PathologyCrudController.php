<?php

namespace App\Http\Controllers;

use App\Models\PathologyRecord;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PathologyCrudController extends Controller
{
    private const SECTION_MAP = [
        'test-categories' => 'Test Categories',
        'tests' => 'Tests',
        'entries' => 'Entries',
        'reports' => 'Reports',
        'menu-plan' => 'Menu Plan',
        'notices' => 'Notices',
        'uploads' => 'Uploads',
        'owners' => 'Owners',
    ];

    public function index(string $section)
    {
        $this->assertValidSection($section);

        return view('pathology.crud', [
            'section' => $section,
            'title' => self::SECTION_MAP[$section],
        ]);
    }

    public function data(string $section): JsonResponse
    {
        $this->assertValidSection($section);

        try {
            $records = PathologyRecord::query()
                ->select('id', 'name', 'description')
                ->where('section', $section)
                ->latest('id')
                ->get();
        } catch (QueryException $exception) {
            if ($this->isMissingTableException($exception)) {
                return response()->json([
                    'data' => [],
                    'warning' => 'Pathology records table is missing. Run migrations to enable this module.',
                ]);
            }

            throw $exception;
        }

        return response()->json(['data' => $records]);
    }

    public function store(Request $request, string $section): JsonResponse
    {
        $this->assertValidSection($section);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        try {
            PathologyRecord::create($validated + ['section' => $section]);
        } catch (QueryException $exception) {
            if ($this->isMissingTableException($exception)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pathology records are not available yet. Please run migrations first.',
                ], 503);
            }

            throw $exception;
        }

        return response()->json([
            'success' => true,
            'message' => self::SECTION_MAP[$section] . ' record created successfully.',
        ]);
    }

    public function update(Request $request, string $section, int $id): JsonResponse
    {
        $this->assertValidSection($section);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        try {
            $record = PathologyRecord::query()
                ->where('section', $section)
                ->findOrFail($id);

            $record->update($validated);
        } catch (QueryException $exception) {
            if ($this->isMissingTableException($exception)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pathology records are not available yet. Please run migrations first.',
                ], 503);
            }

            throw $exception;
        }

        return response()->json([
            'success' => true,
            'message' => self::SECTION_MAP[$section] . ' record updated successfully.',
        ]);
    }

    public function destroy(string $section, int $id): JsonResponse
    {
        $this->assertValidSection($section);

        try {
            $record = PathologyRecord::query()
                ->where('section', $section)
                ->findOrFail($id);

            $record->delete();
        } catch (QueryException $exception) {
            if ($this->isMissingTableException($exception)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pathology records are not available yet. Please run migrations first.',
                ], 503);
            }

            throw $exception;
        }

        return response()->json([
            'success' => true,
            'message' => self::SECTION_MAP[$section] . ' record deleted successfully.',
        ]);
    }

    private function assertValidSection(string $section): void
    {
        abort_unless(array_key_exists($section, self::SECTION_MAP), 404);
    }

    private function isMissingTableException(QueryException $exception): bool
    {
        return (int) ($exception->errorInfo[1] ?? 0) === 1146;
    }
}
