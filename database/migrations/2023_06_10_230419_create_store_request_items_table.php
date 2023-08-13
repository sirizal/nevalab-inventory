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
        Schema::create('store_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_request_id')->constrained();
            $table->integer('menu_plan_item_id')->nullable();
            $table->integer('item_id')->nullable();
            $table->string('description')->nullable();
            $table->integer('uom_id')->nullable();
            $table->integer('request_qty');
            $table->integer('reserved_qty')->default(0);
            $table->integer('delivery_qty')->default(0);
            $table->integer('received_qty')->default(0);
            $table->integer('usage_qty')->default(0);
            $table->integer('return_qty')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_request_items');
    }
};
