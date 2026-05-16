<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // kasir
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('table_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('discount_id')->nullable()->constrained()->nullOnDelete();
            $table->string('receipt_number')->unique();
            $table->decimal('subtotal', 15, 2);
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('tax_amount', 15, 2)->default(0);
            $table->decimal('grand_total', 15, 2);
            $table->enum('payment_method', ['cash', 'qris', 'transfer']);
            $table->decimal('paid_amount', 15, 2);
            $table->decimal('change_amount', 15, 2);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('transactions');
    }
};
