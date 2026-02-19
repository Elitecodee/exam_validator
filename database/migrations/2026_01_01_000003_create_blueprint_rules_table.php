<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('blueprint_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blueprint_id')->constrained()->cascadeOnDelete();
            $table->enum('rule_type', ['type', 'topic', 'difficulty']);
            $table->string('rule_key');
            $table->decimal('expected_percentage', 5, 2);
            $table->decimal('min_percentage', 5, 2);
            $table->decimal('max_percentage', 5, 2);
            $table->timestamps();

            $table->unique(['blueprint_id', 'rule_type', 'rule_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blueprint_rules');
    }
};
