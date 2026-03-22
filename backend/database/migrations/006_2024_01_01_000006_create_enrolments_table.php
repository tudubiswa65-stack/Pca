<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('enrolments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained();
            $table->foreignId('batch_id')->constrained();
            $table->date('enrol_date');
            $table->integer('fee_total');
            $table->integer('fee_paid')->default(0);
            $table->enum('status', ['active', 'completed', 'dropped', 'on_hold'])->default('active');
            $table->boolean('cert_issued')->default(false);
            $table->date('cert_issue_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void { Schema::dropIfExists('enrolments'); }
};