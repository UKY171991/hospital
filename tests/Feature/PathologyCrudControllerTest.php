<?php

namespace Tests\Feature;

use Tests\TestCase;

class PathologyCrudControllerTest extends TestCase
{
    public function test_section_data_endpoint_returns_empty_payload_when_table_is_missing(): void
    {
        $response = $this->withoutMiddleware()->getJson(route('pathology.test-categories.data'));

        $response
            ->assertOk()
            ->assertJsonPath('data', [])
            ->assertJsonPath('warning', 'Pathology records table is missing. Run migrations to enable this module.');
    }

    public function test_invalid_section_returns_not_found(): void
    {
        $response = $this->withoutMiddleware()->get('/pathology/not-a-real-section');

        $response->assertNotFound();
    }
}
