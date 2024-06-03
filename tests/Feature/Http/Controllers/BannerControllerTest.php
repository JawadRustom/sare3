<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Banner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\BannerController
 */
final class BannerControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $banners = Banner::factory()->count(3)->create();

        $response = $this->get(route('banners.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }
}
