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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email', 100)->unique();
            $table->string('phone', 20)->unique();
            $table->string('secondary_phone', 20)->nullable();
            $table->string('father_name', 100);
            $table->string('mother_name', 100);
            $table->string('guardian_name', 100)->nullable();
            $table->string('guardian_phone', 20)->nullable();
            $table->string('blood_group')->nullable();
            $table->string('religion');
            $table->string('gender');
            $table->date('birth_date');
            $table->string('marital_status');
            $table->string('spouse_name')->nullable();
            $table->foreignId('department_id')->constrained()->restrictOnDelete();
            $table->foreignId('designation_id')->constrained()->restrictOnDelete();
            $table->boolean('status')->default(false);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->float('basic')->default(0);
            $table->integer('house_rent')->default(0);
            $table->integer('medical_allowance')->default(0);
            $table->integer('transport')->default(0);
            $table->integer('festival_bonus')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
