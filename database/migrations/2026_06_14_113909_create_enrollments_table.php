<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
        $table->timestamp('enrolled_at')->useCurrent();
        $table->timestamp('completed_at')->nullable();
        $table->decimal('progress', 5, 2)->default(0);
        $table->string('status', 20)->default('active');
        $table->timestamp('updated_at')->useCurrent();

        // Pertahankan keunikan kombinasi user_id dan course_id
        $table->unique(['user_id', 'course_id'], 'unique_enrollment'); 
    });

        DB::statement("ALTER TABLE enrollments ADD CONSTRAINT chk_enrollments_progress CHECK (progress >= 0 AND progress <= 100)");
        DB::statement("ALTER TABLE enrollments ADD CONSTRAINT chk_enrollments_status CHECK (status IN ('active','completed','dropped'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
