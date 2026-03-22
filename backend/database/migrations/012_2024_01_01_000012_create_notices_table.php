<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->string('title', 300);
            $table->enum('type', ['urgent', 'info', 'exam', 'event', 'holiday'])->default('info');
            $table->text('content');
            $table->enum('target_type', ['all', 'course', 'batch'])->default('all');
            $table->unsignedBigInteger('target_id')->nullable();
            $table->string('attachment_url')->nullable();
            $table->timestamp('publish_at');
            $table->timestamp('archived_at')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            
            $table->index(['publish_at', 'type', 'target_type']);
        });
    }
    public function down(): void { Schema::dropIfExists('notices'); }
};