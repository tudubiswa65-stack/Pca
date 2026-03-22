<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('batch_id')->constrained();
            $table->date('date');
            $table->enum('status', ['present', 'absent', 'leave', 'holiday']);
            $table->unsignedBigInteger('marked_by')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['student_id', 'date']);
            $table->index(['batch_id', 'date', 'status']);
        });
    }
    public function down(): void { Schema::dropIfExists('attendance'); }
};