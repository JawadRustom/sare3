<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\BrandController
 */
final class BrandControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $brands = Brand::factory()->count(3)->create();

        $response = $this->get(route('brands.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }
}
