<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("CREATE VIEW task_progress_view 
                AS SELECT `brands`.id, `plans`.id 
                As plan_id, `plans`.approved_on 
                As plan_approved_on,`plans`.status
                AS plan_status, `designs`.id 
                AS design_id ,`designs`.status 
                AS design_status,`designs`.approved_on 
                AS design_approved_on
                FROM `brands`
                JOIN `plans` ON `brands`.`id` = `plans`.`brands_id`
                left JOIN `designs` ON `plans`.`brands_id` = `designs`.`brands_id`
                WHERE `plans`.`status` = 'approved'");
}



    /**
     * Reverse the migrations
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS task_progress_view");
    }
};
