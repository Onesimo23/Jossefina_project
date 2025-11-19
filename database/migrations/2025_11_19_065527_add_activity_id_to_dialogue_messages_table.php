<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::table('dialogue_messages', function (Blueprint $table) {
            $table->foreignId('activity_id')->nullable()->after('project_id')->constrained()->cascadeOnDelete();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('dialogue_messages', function (Blueprint $table) {
            //
        });
    }
};
