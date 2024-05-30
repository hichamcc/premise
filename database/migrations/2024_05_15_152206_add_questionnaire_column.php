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
        Schema::table('questionnaires', function (Blueprint $table) {
            $table->string('genre');
            $table->string('physical_activity')->nullable();
            $table->string('goal')->nullable();
            $table->string('target_zones')->nullable();
            $table->string('walks_frequency')->nullable();
            $table->string('habits')->nullable();
            $table->string('meals_per_day')->nullable();
            $table->string('sleep_hours_per_night')->nullable();
            $table->string('water_consumption')->nullable();
            $table->integer('age');
            $table->integer('current_weight');
            $table->integer('height');
            $table->integer('desired_weight');
            $table->string('calculation_choice')->nullable();
            $table->string('vegetables_not_eaten')->nullable();
            $table->string('fruits_not_eaten')->nullable();
            $table->string('oilseeds_not_eaten')->nullable();
            $table->string('legumes_not_eaten')->nullable();
            $table->string('dairy_products_not_eaten')->nullable();
            $table->string('meat_not_eaten')->nullable();
            $table->string('fish_not_eaten')->nullable();
            $table->string('intolerances_or_allergies')->nullable();
            $table->string('diseases_diagnosed_by_doctor')->nullable();
            $table->string('left_arm_circumference')->nullable();
            $table->string('waist_circumference')->nullable();
            $table->string('hip_circumference')->nullable();
            $table->string('chest_circumference')->nullable();
            $table->string('front_photo')->nullable();
            $table->string('side_photos')->nullable();
            $table->string('back_photo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questionnaire', function (Blueprint $table) {
            //
        });
    }
};
