<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrolment_id')->constrained()->onDelete('cascade');
            $table->integer('amount');
            $table->enum('mode', ['cash', 'online', 'upi', 'cheque']);
            $table->string('receipt_no')->unique();
            $table->date('date');
            $table->unsignedBigInteger('recorded_by')->nullable();
            $table->foreign('recorded_by')->references('id')->on('users');
            $table->string('receipt_url')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('payments'); }
};