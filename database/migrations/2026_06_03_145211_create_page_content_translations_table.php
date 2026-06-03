<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_content_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_content_id')->constrained('page_contents')->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['page_content_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_content_translations');
    }
};
