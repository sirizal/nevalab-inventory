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
        Schema::create('menu_plans', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->dateTime('plan_date');
            $table->integer('estimate_pob')->default(1000);
            $table->integer('actual_pob')->default(0);
            $table->foreignId('menu_time_id')->constrained();
            $table->foreignId('product_group_id')->constrained('product_groups');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_plans');
    }
};
