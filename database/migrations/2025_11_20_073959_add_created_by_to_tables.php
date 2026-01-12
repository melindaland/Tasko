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
        // Ajouter created_by aux sprints
        Schema::table('sprints', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->after('project_id')->constrained('users')->onDelete('set null');
        });

        // Ajouter created_by aux epics
        Schema::table('epics', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->after('project_id')->constrained('users')->onDelete('set null');
        });

        // Ajouter created_by aux tasks
        Schema::table('tasks', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->after('project_id')->constrained('users')->onDelete('set null');
        });

        // Ajouter created_by aux releases
        Schema::table('releases', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->after('project_id')->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sprints', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
        });

        Schema::table('epics', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
        });

        Schema::table('releases', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
        });
    }
};
