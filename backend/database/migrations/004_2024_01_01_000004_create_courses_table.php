<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('slug', 200)->unique();
            $table->string('code', 20)->unique();
            $table->enum('category', ['basic', 'professional', 'advanced', 'certification']);
            $table->smallInteger('duration_months');
            $table->integer('fee');
            $table->text('description')->nullable();
            $table->json('syllabus')->nullable();
            $table->string('feature_image_url')->nullable();
            $table->string('icon', 10)->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->boolean('show_on_website')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void { Schema::dropIfExists('courses'); }
};