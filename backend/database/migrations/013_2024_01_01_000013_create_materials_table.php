<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('title', 300);
            $table->foreignId('course_id')->constrained();
            $table->string('module_name', 200)->nullable();
            $table->text('file_url');
            $table->text('storage_path');
            $table->string('file_type', 50);
            $table->integer('download_count')->default(0);
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('materials'); }
};