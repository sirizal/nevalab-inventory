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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('description');
            $table->string('description_uom')->nullable();
            $table->text('specification')->nullable();
            $table->integer('grammage')->nullable();
            $table->decimal('standard_cost', 20, 2);
            $table->integer('status')->default('0');
            $table->integer('category_1')->nullable();
            $table->integer('category_2')->nullable();
            $table->integer('category_3')->nullable();
            $table->foreignId('item_type_id')->constrained();
            $table->foreignId('uom_id')->constrained();
            $table->foreignId('storage_type_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
