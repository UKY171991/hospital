<?php

namespace App\Http\Controllers;

use App\Models\PathologyRecord;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
            $recordsQuery = PathologyRecord::query()
                ->from('pathology_records as records')
                ->leftJoin('pathology_main_test_categories as main_categories', 'main_categories.id', '=', 'records.main_test_category_id')
                ->leftJoin('pathology_records as test_categories', function ($join) {
                    $join->on('test_categories.id', '=', 'records.test_category_id')
                        ->where('test_categories.section', 'test-categories');
                })
                ->select(
                    'records.id',
                    'records.main_test_category_id',
                    'records.test_category_id',
                    'records.name',
                    'records.description',
                    'main_categories.name as main_test_category_name',
                    'test_categories.name as test_category_name'
                )
                ->where('records.section', $section)
                ->latest('records.id')
                ->when(
                    $section === 'test-categories' && request()->filled('main_test_category_id'),
                    fn ($query) => $query->where('records.main_test_category_id', request('main_test_category_id'))
                );

            $records = $recordsQuery->get();
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
            'main_test_category_id' => [
                'nullable',
                'integer',
                'exists:pathology_main_test_categories,id',
                Rule::requiredIf(in_array($section, ['test-categories', 'tests'], true)),
            ],
            'test_category_id' => [
                'nullable',
                'integer',
                Rule::exists('pathology_records', 'id')->where('section', 'test-categories'),
                Rule::requiredIf($section === 'tests'),
            ],
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        if ($section !== 'tests') {
            $validated['test_category_id'] = null;
        }

        if ($section === 'tests') {
            $isValidPair = PathologyRecord::query()
                ->where('section', 'test-categories')
                ->where('id', $validated['test_category_id'])
                ->where('main_test_category_id', $validated['main_test_category_id'])
                ->exists();

            if (! $isValidPair) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected test category does not belong to the selected main test category.',
                ], 422);
            }
        }

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
            'main_test_category_id' => [
                'nullable',
                'integer',
                'exists:pathology_main_test_categories,id',
                Rule::requiredIf(in_array($section, ['test-categories', 'tests'], true)),
            ],
            'test_category_id' => [
                'nullable',
                'integer',
                Rule::exists('pathology_records', 'id')->where('section', 'test-categories'),
                Rule::requiredIf($section === 'tests'),
            ],
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        if ($section !== 'tests') {
            $validated['test_category_id'] = null;
        }

        if ($section === 'tests') {
            $isValidPair = PathologyRecord::query()
                ->where('section', 'test-categories')
                ->where('id', $validated['test_category_id'])
                ->where('main_test_category_id', $validated['main_test_category_id'])
                ->exists();

            if (! $isValidPair) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected test category does not belong to the selected main test category.',
                ], 422);
            }
        }

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
