<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('phone', 15);
            $table->string('email')->nullable();
            $table->string('course_interest', 200)->nullable();
            $table->text('message')->nullable();
            $table->enum('status', ['new', 'contacted', 'admitted', 'not_interested'])->default('new');
            $table->text('notes')->nullable();
            $table->date('follow_up_date')->nullable();
            $table->unsignedBigInteger('converted_student_id')->nullable();
            $table->foreign('converted_student_id')->references('id')->on('students');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('enquiries'); }
};