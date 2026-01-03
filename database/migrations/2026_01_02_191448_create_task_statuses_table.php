<?php

use Database\Seeders\TaskStatusesTableSeeder;
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
        Schema::create('task_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 32)->unique();
            $table->string('slug', 32)->unique();
            $table->string('border_style', 16)->default('solid');
            $table->string('color_background', 32)->default('transparent');
            $table->string('color_border', 32)->default('#000000');
            $table->string('color_text', 32)->default('#000000');
            $table->timestamps();
        });

        (new TaskStatusesTableSeeder)->run();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_statuses');
    }
};
