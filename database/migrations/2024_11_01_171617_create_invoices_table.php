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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->date('invoice_date');
            $table->date('due_date');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete(action: 'cascade');
            $table->unsignedBigInteger('section_id');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->decimal('amount_collection', 20, 2)->nullable();
            $table->decimal('amount_commission', 20, 2);
            $table->decimal('discount', 20, 2);  // Added precision and scale
            $table->string('rate_vat');
            $table->decimal('value_vat', 20, 2);  // Increased precision
            $table->decimal('total', 20, 2);       // Increased precision
            $table->string('status', 50);
            $table->integer('value_status');
            $table->text(column: 'note')->nullable();
            $table->date(column: 'payment_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
