<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement(<<<SQL
            INSERT INTO
                `task_statuses` (`id`, `name`, `slug`, `border_style`, `color_background`, `color_border`, `color_text`)
            VALUES
                (1, 'Backlog', 'backlog', 'dotted', 'transparent', '#000000', '#000000'),
                (2, 'To do', 'to-do', 'solid', 'transparent', '#000000', '#000000'),
                (3, 'In Progress', 'in-progress', 'solid', 'oklch(76.9% 0.188 70.08)', 'oklch(66.6% 0.179 58.318)', 'oklch(47.3% 0.137 46.201)'), -- Tailwind Colors: Amber-500, Amber-600, and Amber-800
                (4, 'In Review', 'in-review', 'solid', 'oklch(71.5% 0.143 215.221)', 'oklch(60.9% 0.126 221.723)', 'oklch(45% 0.085 224.283)'), -- Tailwind Colors: Cyan-500, Cyan-600, and Cyan-800
                (5, 'Done', 'done', 'solid', 'oklch(72.3% 0.219 149.579)', 'oklch(62.7% 0.194 149.214)', 'oklch(44.8% 0.119 151.328)') -- Tailwind Colors: Green-500, Green-600, and Green-800
            ON DUPLICATE KEY UPDATE
                `name` = VALUES(`name`),
                `slug` = VALUES(`slug`),
                `updated_at` = CURRENT_TIMESTAMP;
        SQL);
    }
}
