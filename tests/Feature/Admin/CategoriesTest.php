<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;


class CategoriesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake();

        $this->withHeaders([
            'accept' => 'application/json'
        ]);
    }

    public function test_can_see_index_page(): void
    {
        $this->withoutExceptionHandling();
        $this->actingAs(User::factory()->create());

        $response = $this->get('/admin/categories');

        $response->assertOk();
    }

    public function test_can_see_create_page(): void
    {
        $this->actingAs(User::factory()->create());

        $this->withoutExceptionHandling();
        $response = $this->get('/admin/categories/create');

        $response->assertOk();
    }

    public function test_admin_can_create_category(): void
    {
        $this->actingAs(User::factory()->create());

        $this->withoutExceptionHandling();

        $icon = File::create('sweets.png');


        $data = ['title' => 'Sweets', 'icon' => $icon];

        $response = $this->post('admin/categories', $data);
        $response->assertRedirect();

        $this->assertDatabaseCount('categories', 1);

        $category = Category::first();
        $data['icon'] = 'images/categories/'.$icon->hashName();

        $this->assertEquals($data, [
            'title' => $category->title,
            'icon' => $category->icon,
        ]);

        Storage::disk('public')->assertExists($category->url);
    }
}
