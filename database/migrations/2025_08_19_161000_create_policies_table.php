<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('policies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('policy_no')->unique();
            $table->enum('policy_status', ['Active', 'Inactive', 'Cancelled', 'Expired', 'Pending'])->default('Pending');
            $table->string('policy_type')->default('Auto');
            $table->date('policy_effective_date');
            $table->date('policy_expiration_date');
            
            $table->json('policy_holder');
            $table->json('drivers');
            $table->json('vehicles');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('policies');
    }
};