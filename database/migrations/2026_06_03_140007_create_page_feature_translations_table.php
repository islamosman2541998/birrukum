<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_feature_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_feature_id')->constrained('page_features')->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['page_feature_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_feature_translations');
    }
};
