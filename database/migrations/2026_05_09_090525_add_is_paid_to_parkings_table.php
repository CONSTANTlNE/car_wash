<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('parkings', function (Blueprint $table) {
            $table->boolean('is_paid')->default(false)->after('parking_rate');
            $table->string('payment_method')->nullable()->after('is_paid');
        });
    }

    public function down(): void
    {
        Schema::table('parkings', function (Blueprint $table) {
            $table->dropColumn(['is_paid', 'payment_method']);
        });
    }
};
