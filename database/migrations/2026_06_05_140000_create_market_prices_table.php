<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('market_prices', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('title');
            $table->string('category')->nullable();
            $table->decimal('price', 20, 2)->nullable();
            $table->decimal('change_amount', 20, 2)->nullable();
            $table->decimal('change_percent', 8, 2)->nullable();
            $table->string('currency')->default('تومان');
            $table->string('unit')->nullable();
            $table->string('source_name')->nullable();
            $table->string('source_url')->nullable();
            $table->timestamp('fetched_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->json('raw_data')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('market_prices');
    }
};
