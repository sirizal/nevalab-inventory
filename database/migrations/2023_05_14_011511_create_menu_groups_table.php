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
        Schema::create('menu_groups', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('image');
            $table->foreignId('menu_time_id')->constrained();
            $table->foreignId('product_group_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_groups');
    }
};
