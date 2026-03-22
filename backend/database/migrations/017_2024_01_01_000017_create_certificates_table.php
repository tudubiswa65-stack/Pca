<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained();
            $table->string('cert_no')->unique();
            $table->date('issue_date');
            $table->enum('status', ['issued', 'revoked'])->default('issued');
            $table->string('file_url')->nullable();
            $table->string('qr_token')->unique();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('certificates'); }
};