<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('sku')->nullable();
            $table->decimal('price', 15, 2);
            $table->integer('stock')->default(0);
            $table->boolean('is_available')->default(true);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('products');
    }
};
