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
    Schema::create('page_features', function (Blueprint $table) {
        $table->id();
        $table->foreignId('page_id')->constrained('pages')->cascadeOnDelete();
        $table->string('image')->nullable();
        $table->string('url')->nullable();
        $table->integer('sort')->default(0);
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('page_features');
}
};
