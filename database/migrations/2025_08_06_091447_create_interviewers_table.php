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
        Schema::create('interviewers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->constrained()->cascadeOnDelete();
            $table->string('job_position');
            $table->text('job_description');
            $table->string('duration'); // assuming duration is like "30 minutes" or similar
            $table->string('interview_type'); // stored as CSV: technical, behavioral etc.
            $table->integer('num_questions');
            $table->text('question'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interviewers');
    }
};
