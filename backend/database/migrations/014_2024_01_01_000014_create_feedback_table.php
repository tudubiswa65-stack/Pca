<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->foreign('student_id')->references('id')->on('students');
            $table->enum('type', ['general', 'faculty', 'course', 'complaint', 'suggestion']);
            $table->string('category', 100)->nullable();
            $table->smallInteger('rating')->nullable();
            $table->text('comment')->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->enum('status', ['open', 'in_progress', 'resolved'])->default('open');
            $table->text('reply')->nullable();
            $table->unsignedBigInteger('replied_by')->nullable();
            $table->foreign('replied_by')->references('id')->on('users');
            $table->timestamp('replied_at')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('feedback'); }
};