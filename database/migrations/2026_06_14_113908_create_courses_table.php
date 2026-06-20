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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('description');
            $table->foreignId('category_id')->constrained('course_categories')->onDelete('restrict');
            $table->foreignId('instructor_id')->constrained('users')->onDelete('restrict');
            $table->decimal('rating', 4, 2)->default(0);
            $table->string('thumbnail', 255)->nullable();
            $table->string('level', 50)->default('beginner');
            $table->integer('duration');
            $table->string('status', 20)->default('draft');
            $table->integer('enrolled_count')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes();
        });
        // CHECK constraints
        DB::statement("ALTER TABLE courses ADD CONSTRAINT chk_courses_status CHECK (status IN ('draft','published'))");
        DB::statement("ALTER TABLE courses ADD CONSTRAINT chk_courses_level CHECK (level IN ('beginner','intermediate','advanced'))");
        DB::statement("ALTER TABLE courses ADD CONSTRAINT chk_courses_duration CHECK (duration >= 1)");
        DB::statement("ALTER TABLE courses ADD CONSTRAINT chk_courses_rating CHECK (rating >= 0 AND rating <= 10)");

        // Indeks tambahan
        Schema::table('courses', function (Blueprint $table) {
            $table->index('level', 'idx_courses_level');
            $table->index('rating', 'idx_courses_rating');
            $table->index('enrolled_count', 'idx_courses_enrolled_count');
            $table->index('duration', 'idx_courses_duration');
            $table->index('title', 'idx_courses_title');
        });

        // FULLTEXT Index
        DB::statement('ALTER TABLE courses ADD FULLTEXT INDEX ft_courses_search (title, description)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
