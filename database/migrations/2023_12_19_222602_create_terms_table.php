<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('terms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('taxonomy_id')->constrained()->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('terms')->nullOnDelete();
            $table->string('slug');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['tenant_id', 'taxonomy_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terms');
    }
};
