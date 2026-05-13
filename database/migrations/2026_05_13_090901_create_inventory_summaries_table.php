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
    Schema::create('inventory_summaries', function (Blueprint $table) {
        $table->id();
        $table->foreignId('product_id')->constrained()->onDelete('cascade');
        $table->foreignId('warehouse_id')->constrained()->onDelete('cascade');
        $table->foreignId('batch_id')->nullable()->constrained('product_batches')->onDelete('cascade');
        $table->integer('quantity')->default(0);
        $table->timestamps();
        
        // ป้องกันข้อมูลซ้ำซ้อนในคลังเดียวกัน ล็อตเดียวกัน
        $table->unique(['product_id', 'warehouse_id', 'batch_id'], 'inv_summary_unique');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_summaries');
    }
};
