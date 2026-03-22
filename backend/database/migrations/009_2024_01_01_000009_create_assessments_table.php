<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->foreignId('course_id')->constrained();
            $table->foreignId('batch_id')->constrained();
            $table->date('date');
            $table->integer('max_marks');
            $table->integer('pass_marks');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('assessments'); }
};