<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('designation', 100);
            $table->string('qualification')->nullable();
            $table->text('subjects')->nullable();
            $table->date('join_date')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('staff'); }
};