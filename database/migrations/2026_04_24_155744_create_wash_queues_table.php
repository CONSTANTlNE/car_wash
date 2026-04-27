<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('wash_queues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained('cars')->cascadeOnDelete();
            $table->foreignId('car_wash_box_id')->nullable()->constrained('carwash_boxes')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('wash_type_id')->nullable()->constrained('wash_types')->cascadeOnDelete();
            $table->string('wash_type')->nullable()->index();
            $table->decimal('wash_price', 10, 2)->nullable();
            $table->boolean('is_paid')->default(false);
            $table->string('wash_date')->nullable();
            $table->string('status')->default('pending');
            $table->decimal('washer_%', 10, 2)->default(0);
            $table->decimal('washer_commission', 10, 2)->default(0);
            $table->string('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wash_queues');
    }
};
