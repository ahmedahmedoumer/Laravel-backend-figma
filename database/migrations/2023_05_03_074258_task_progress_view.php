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
        DB::statement("CREATE VIEW task_progress_view AS 
                SELECT `brands`.id, `plan_libraries`.id As plan_id,`plan_libraries`.approved_on As plan_approved_on, `design_libraries`.id AS design_id ,`design_libraries`.status AS design_status,`design_libraries`.approved_on AS design_approved_date
                FROM `brands`
                JOIN `plan_libraries` ON `brands`.`id` = `plan_libraries`.`brands_id`
                left JOIN `design_libraries` ON `plan_libraries`.`brands_id` = `design_libraries`.`brands_id`
                WHERE `plan_libraries`.`status` = 'approved'");
}



    /**
     * Reverse the migrations
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS task_progress_view");
    }
};
