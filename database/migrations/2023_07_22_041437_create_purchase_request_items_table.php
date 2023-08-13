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
        Schema::create('purchase_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_request_id')->constrained();
            $table->foreignId('item_id')->constrained();
            $table->foreignId('warehouse_id')->constrained();
            $table->string('gl_no')->nullable();
            $table->string('description')->nullable();
            $table->string('uom_id')->nullable();
            $table->integer('price')->default(0);
            $table->decimal('vat', 8, 2)->default(0);
            $table->decimal('request_qty', 10, 2)->default(0);
            $table->decimal('toreceive_qty', 10, 2)->default(0);
            $table->decimal('pass_qc_qty', 10, 2)->default(0);
            $table->decimal('reject_qc_qty', 10, 2)->default(0);
            $table->decimal('received_qty', 10, 2)->default(0);
            $table->decimal('toinvoice_qty', 10, 2)->default(0);
            $table->decimal('invoiced_qty', 10, 2)->default(0);
            $table->decimal('return_qty', 10, 2)->default(0);
            $table->date('production_date')->nullable();
            $table->date('expire_date')->nullable();
            $table->string('doc_no')->nullable();
            $table->string('packing_description')->nullable();
            $table->string('reject_reason')->nullable();
            $table->string('job_no')->nullable();
            $table->string('task_no')->nullable();
            $table->string('reason_not_deliver')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_request_items');
    }
};
