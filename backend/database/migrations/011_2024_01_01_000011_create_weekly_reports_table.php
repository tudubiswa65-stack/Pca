<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('weekly_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('batch_id')->constrained();
            $table->smallInteger('week_no');
            $table->date('week_start');
            $table->text('topics_covered')->nullable();
            $table->smallInteger('assignments_done')->default(0);
            $table->smallInteger('assignments_total')->default(0);
            $table->decimal('quiz_score', 5, 2)->nullable();
            $table->text('remarks')->nullable();
            $table->smallInteger('rating')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('weekly_reports'); }
};