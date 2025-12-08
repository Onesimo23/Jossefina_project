<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('evidence_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evidence_id')->constrained('evidences')->onDelete('cascade');
            $table->string('filename');
            $table->string('disk')->default('public');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('evidence_photos');
    }
};
