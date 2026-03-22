<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('gallery', function (Blueprint $table) {
            $table->id();
            $table->string('caption', 300)->nullable();
            $table->string('category', 100)->nullable();
            $table->text('file_url');
            $table->text('storage_path');
            $table->boolean('is_public')->default(true);
            $table->integer('sort_order')->default(0);
            $table->unsignedBigInteger('uploaded_by')->nullable();
            $table->foreign('uploaded_by')->references('id')->on('users');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('gallery'); }
};