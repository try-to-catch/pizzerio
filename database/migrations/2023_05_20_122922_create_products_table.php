<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('slug')->unique();

            $table->decimal('price', 6);
            $table->decimal('sale_price', 6)->nullable();

            $table->smallInteger('priority')->default(1);

            $table->string('thumbnail');
            $table->string('ingredients')->nullable();
            $table->text('description')->nullable();

            $table->boolean('is_for_sale')->default(false);

            $table->string('banner')->default(false)->nullable();

            $table->foreignIdFor(Category::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!app()->isProduction()) {
            Schema::dropIfExists('products');
        }
    }
};
