<?php

namespace Tests\Feature;

use Tests\TestCase;

class PathologyMainTestCategoryControllerTest extends TestCase
{
    public function test_data_endpoint_returns_empty_payload_when_table_is_missing(): void
    {
        $response = $this->withoutMiddleware()->getJson(route('pathology.main-test-categories.data'));

        $response
            ->assertOk()
            ->assertJsonPath('data', [])
            ->assertJsonPath('warning', 'Pathology main test category table is missing. Run migrations to enable this module.');
    }
}
