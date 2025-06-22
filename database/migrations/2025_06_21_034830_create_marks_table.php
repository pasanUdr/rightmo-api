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
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            // Match type and sign with students.index_no
            $table->integer('index_no')->unsigned();
            $table->foreign('index_no')
                ->references('index_no')
                ->on('students')
                ->cascadeOnDelete();

            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->integer('marks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marks');
    }
};
