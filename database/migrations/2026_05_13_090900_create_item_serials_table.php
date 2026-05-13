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
    Schema::create('item_serials', function (Blueprint $table) {
        $table->id();
        $table->string('serial_number')->unique();
        $table->foreignId('product_id')->constrained()->onDelete('cascade');
        $table->foreignId('batch_id')->nullable()->constrained('product_batches')->onDelete('set null');
        $table->foreignId('warehouse_id')->constrained()->onDelete('cascade');
        $table->string('status')->default('AVAILABLE'); // AVAILABLE, IN_TRANSIT, SOLD
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_serials');
    }
};
