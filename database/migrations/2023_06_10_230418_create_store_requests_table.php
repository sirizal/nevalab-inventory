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
        Schema::create('store_requests', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->date('request_delivery_date')->nullable();
            $table->foreignId('product_type_id')->constrained();
            $table->foreignId('site_id')->constrained();
            $table->integer('menu_plan_id')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->string('status')->default('created');
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_requests');
    }
};
