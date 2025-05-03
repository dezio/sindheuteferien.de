<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('school_holiday', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('name');
            $table->string('regional_scope');
            $table->string('temporal_scope');
            $table->boolean('nationwide');
            $table->json('subdivisions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_holiday');
    }
};
