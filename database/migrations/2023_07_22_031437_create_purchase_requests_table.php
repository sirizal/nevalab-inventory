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
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->date('request_date');
            $table->date('request_delivery_date')->nullable();
            $table->date('request_receive_date')->nullable();
            $table->foreignId('product_type_id')->nullable()->constrained();
            $table->foreignId('site_id')->constrained();
            $table->integer('create_user')->nullable();
            $table->integer('modify_user')->nullable();
            $table->foreignId('vendor_id')->constrained();
            $table->integer('status')->default(0);
            $table->string('purchase_no')->nullable();
            $table->date('purchase_date')->nullable();
            $table->integer('purchase_user')->nullable();
            $table->string('purchase_type')->default('item');
            $table->string('purchase_no_file')->nullable();
            $table->string('delivery_no')->nullable();
            $table->date('delivery_date')->nullable();
            $table->integer('delivery_user')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('driver_ktp')->nullable();
            $table->string('driver_phone_no')->nullable();
            $table->string('delivery_by')->nullable();
            $table->string('ncr_no')->nullable();
            $table->date('ncr_date')->nullable();
            $table->date('inspection_date')->nullable();
            $table->string('ncr_remark')->nullable();
            $table->integer('inspection_status')->nullable();
            $table->integer('inspection_user')->nullable();
            $table->string('receive_no')->nullable();
            $table->date('receive_date')->nullable();
            $table->integer('receive_user')->nullable();
            $table->string('erp_receive_no')->nullable();
            $table->date('erp_receive_date')->nullable();
            $table->integer('erp_receive_user')->nullable();
            $table->string('return_no')->nullable();
            $table->date('return_date')->nullable();
            $table->integer('return_user')->nullable();
            $table->string('vendor_invoice_no')->nullable();
            $table->integer('vendor_invoice_user')->nullable();
            $table->date('vendor_invoice_date')->nullable();
            $table->date('vendor_invoice_send_date')->nullable();
            $table->date('vendor_invoice_receive_date')->nullable();
            $table->date('vendor_invoice_reject_date')->nullable();
            $table->string('vendor_invoice_reject_reason')->nullable();
            $table->date('vendor_invoice_due_date')->nullable();
            $table->date('vendor_invoice_estimate_payment_date')->nullable();
            $table->integer('deliver_ontime')->default(0);
            $table->decimal('deliver_infull', 10, 2)->default(0);
            $table->integer('receive_ontime')->default(0);
            $table->decimal('receive_infull', 10, 2)->default(0);
            $table->decimal('total_request_qty', 10, 2)->default(0);
            $table->decimal('total_delivery_qty', 10, 2)->default(0);
            $table->decimal('total_pass_qc_qty', 10, 2)->default(0);
            $table->decimal('total_reject_qc_qty', 10, 2)->default(0);
            $table->decimal('total_received_qty', 10, 2)->default(0);
            $table->decimal('total_return_qty', 10, 2)->default(0);
            $table->decimal('total_invoice_qty', 10, 2)->default(0);
            $table->decimal('total_request_amount', 10, 2)->default(0);
            $table->decimal('total_delivery_amount', 10, 2)->default(0);
            $table->decimal('total_pass_qc_amount', 10, 2)->default(0);
            $table->decimal('total_reject_qc_amount', 10, 2)->default(0);
            $table->decimal('total_received_amount', 10, 2)->default(0);
            $table->decimal('total_return_amount', 10, 2)->default(0);
            $table->decimal('total_invoice_amount', 10, 2)->default(0);
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requests');
    }
};
