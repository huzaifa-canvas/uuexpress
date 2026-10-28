<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_name', 120);
            $table->string('email', 150);
            $table->string('phone', 40)->nullable();
            $table->string('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('postcode', 20)->nullable();
            $table->text('notes')->nullable();
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->string('status', 20)->default('processing'); // processing | completed | cancelled | refunded
            $table->string('payment_status', 20)->default('unpaid'); // unpaid | paid
            $table->string('payment_intent_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
