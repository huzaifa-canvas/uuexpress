<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedSmallInteger('boxes')->default(0)->after('dropoff_address');
            $table->unsignedSmallInteger('bags')->default(0)->after('boxes');
            $table->unsignedSmallInteger('envelopes')->default(0)->after('bags');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['boxes', 'bags', 'envelopes']);
        });
    }
};
