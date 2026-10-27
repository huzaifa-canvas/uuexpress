<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('image');                 // card / hero image
            $table->string('desc');                  // short card description
            $table->string('tint', 16)->default('green');
            // Detail page content (replaces the old service-*.php files)
            $table->text('intro')->nullable();       // long paragraph on /services
            $table->string('detail_heading')->nullable();
            $table->text('detail_body')->nullable();
            $table->json('features')->nullable();    // bullet list
            $table->string('cta_heading')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
