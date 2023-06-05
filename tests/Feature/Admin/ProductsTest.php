<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake();
        Image::fake();

        $this->withHeaders([
            'accept' => 'application/json'
        ]);
    }

    public function test_admin_can_see_index_page(): void
    {
        $this->withoutExceptionHandling();

        $this->actingAs(User::factory()->create());

        $response = $this->get('/admin/products');

        $response->assertOk();
    }

    public function test_admin_can_see_create_page(): void
    {
        $this->withoutExceptionHandling();

        $this->actingAs(User::factory()->create());

        $response = $this->get('/admin/products/create');

        $response->assertOk();
    }

    public function test_admin_can_see_edit_page(): void
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        $category = Category::factory()->count(1)->create(['user_id' => $user->id])->first();
        $this->assertDatabaseCount('categories', 1);

        $product = Product::factory()->count(1)->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ])->first();
        $this->assertDatabaseCount('products', 1);

        $response = $this->get("/admin/products/$product->slug");

        $response->assertOk();
    }

    public function test_admin_can_create_product(): void
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        Category::factory()->count(1)->create(['user_id' => $user->id])->first();

        $thumbnail = UploadedFile::fake()->image('avatar.jpg', 500, 500);

        $data = [
            'title' => 'Pizza Pepperoni',
            'banner' => 'New',
            'category_id' => 1,
            'description' => 'Delicious pizza for the whole family, buy and rejoice, bc our pizza is the best',
            'ingredients' => '1/2 cup pizza sauce (see below) 18 to 20 slices pepperoni',
            'is_for_sale' => true,
            'price' => 1.23,
            'sale_price' => null,
            'priority' => 5,
            'thumbnail' => $thumbnail
        ];

        $response = $this->post('/admin/products', $data);
        $response->assertRedirect();

        $this->assertDatabaseCount('products', 1);

        $product = Product::first();
        $data['thumbnail'] = 'images/products/' . $thumbnail->hashName();

        $this->assertEquals($data, [
            'title' => $product->title,
            'banner' => $product->banner,
            'category_id' => $product->category_id,
            'description' => $product->description,
            'ingredients' => $product->ingredients,
            'is_for_sale' => $product->is_for_sale,
            'price' => $product->price,
            'sale_price' => $product->sale_price,
            'priority' => $product->priority,
            'thumbnail' => $product->thumbnail,

        ]);

        $this->assertFileExists('storage/'.$product->thumbnail);
    }

    public function test_admin_can_update_product(): void
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        $category = Category::factory()->count(1)->create(['user_id' => $user->id])->first();
        $this->assertDatabaseCount('categories', 1);

        $product = Product::factory()->count(1)->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ])->first();
        $this->assertDatabaseCount('products', 1);

        $thumbnail = UploadedFile::fake()->image('avatar.jpg', 500, 500);

        $updatedPost = [
            'title' => 'Pizza Pepperoni',
            'banner' => 'New',
            'category_id' => 1,
            'description' => 'Delicious pizza for the whole family, buy and rejoice, bc our pizza is the best',
            'ingredients' => '1/2 cup pizza sauce (see below) 18 to 20 slices pepperoni',
            'is_for_sale' => true,
            'price' => 1.23,
            'sale_price' => null,
            'priority' => 5,
            'thumbnail' => $thumbnail
        ];

        $response = $this->patch("/admin/products/$product->slug", $updatedPost);
        $response->assertRedirect();

        $this->assertDatabaseCount('products', 1);

        $product = Product::first();
        $updatedPost['thumbnail'] = 'images/products/' . $thumbnail->hashName();

        $this->assertEquals($updatedPost, [
            'title' => $product->title,
            'banner' => $product->banner,
            'category_id' => $product->category_id,
            'description' => $product->description,
            'ingredients' => $product->ingredients,
            'is_for_sale' => $product->is_for_sale,
            'price' => $product->price,
            'sale_price' => $product->sale_price,
            'priority' => $product->priority,
            'thumbnail' => $product->thumbnail,

        ]);

        $this->assertFileExists('storage/'.$product->thumbnail);
    }

    public function test_admin_can_delete_product(): void
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        $category = Category::factory()->count(1)->create(['user_id' => $user->id])->first();
        $this->assertDatabaseCount('categories', 1);

        $product = Product::factory()->count(1)->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ])->first();

        $this->assertDatabaseCount('products', 1);

        $response = $this->delete("/admin/products/{$product->slug}");
        $response->assertRedirect();

        $this->assertDatabaseCount('products', 0);
    }
}
