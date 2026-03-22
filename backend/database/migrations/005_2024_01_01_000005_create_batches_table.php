<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('faculty_id')->nullable();
            $table->foreign('faculty_id')->references('id')->on('staff');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->json('schedule')->nullable();
            $table->smallInteger('capacity');
            $table->string('room', 100)->nullable();
            $table->enum('status', ['upcoming', 'active', 'completed', 'cancelled']);
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void { Schema::dropIfExists('batches'); }
};