<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignUuid('course_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('payment_proof_path')->nullable();
            $table->enum('status', ['approved', 'pending', 'rejected'])->default('pending');
            $table->string('payment_token')->nullable();
            $table->timestamp('payment_token_expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
